var Mandrill = require("cloud/mandrill.js");
var Image = require("parse-image");

var adminEmailAddress = "info@doyourownmortgage.com";

Parse.Cloud.define("sendAdminContactMail", function(request, response) {

Mandrill.sendEmail({
  message: {
    text: request.params.text,
    subject: "Contact form email",
    from_email: request.params.email,
    from_name: request.params.name,
    to: request.params.recipients
  },
  async: true
},{
  success: function(httpResponse) {
    console.log(httpResponse);
    response.success("Email sent!");
  },
  error: function(httpResponse) {
    console.error(httpResponse);
    response.error("Uh oh, something went wrong");
  }
});
});

Parse.Cloud.define("sendThankYouContactMail", function(request, response) {
Mandrill.sendEmail({
  message: {
    text: "We will get back to you as soon as we can.",
    subject: "Thank you for the email",
    from_email: "info@doyourownmortgage.com",
    from_name: "Do Your Own Mortgage",
    to: [
      {
        email: request.params.email,
        name: request.params.name
      }
    ]
  },
  async: true
},{
  success: function(httpResponse) {
    console.log(httpResponse);
    response.success("Email sent!");
  },
  error: function(httpResponse) {
    console.error(httpResponse);
    response.error("Uh oh, something went wrong");
  }
});
});
 
Parse.Cloud.define("sendMail", function(request, response) {
    Mandrill.sendTemplate("thank-you", {}, {
            auto_html: true,
            auto_text: true,
            subject: "Thank you for your application",
            from_email: "noreply@doyourownmortgage.com",
            bcc_address: "lionel@ecgi.ca",
            from_name: "Do Your Own Mortgage",
            merge: true,
            merge_vars: [
                {
                    "rcpt": request.params.email,
                    "vars": [
                        {
                            "name": "name",
                            "content": request.params.name
                        },
                        {
                            "name": "aid",
                            "content": request.params.appId
                        }
                    ]
                }
            ],
            to: [
                {
                    email: request.params.email,
                    name: request.params.name
                }
            ]
        },
        true
    ).then(function(){
            response.success("Email sent!");
    });

  
});
Parse.Cloud.define("sendMailReferral", function(request, response) {
    Mandrill.sendTemplate("referral", {}, {
            auto_html: true,
            auto_text: true,
            subject: request.params.name+" Wants You to Do Your Own Mortgage",
            from_email: "noreply@doyourownmortgage.com",
            from_name: "Do Your Own Mortgage",
            merge: true,
            merge_vars: [
                {
                    "rcpt": request.params.email,
                    "vars": [
                        {
                            "name": "profileimg",
                            "content": request.params.pimg
                        },
                        {
                            "name": "name",
                            "content": request.params.name
                        },
                        {
                            "name": "cashback",
                            "content": request.params.cashback
                        },
                        {
                            "name": "userid",
                            "content": request.params.uid
                        }
                    ]
                }
            ],
            to: [
                {
                    email: request.params.email,
                    name: request.params.name
                }
            ]
        },
        true
    ).then(function(){
            response.success("Email sent!");
        });
 
});
Parse.Cloud.define("getUserEmail", function(request, response) {
    Parse.Cloud.useMasterKey();
    var userQuery = new Parse.Query(Parse.User);
    userQuery.equalTo("email", request.params.email);
    userQuery.first({
        success: function(results) {
            response.success(results);
        },
        error: function(error){
            response.error("Uh oh, something went wrong");
        }
    });
});
Parse.Cloud.define("getUser", function(request, response) {
    Parse.Cloud.useMasterKey();
    var userQuery = new Parse.Query(Parse.User);
    userQuery.equalTo("objectId", request.params.user);
    userQuery.first({
        success: function(results) {
            response.success(results);
        },
        error: function(error){
            response.error("Uh oh, something went wrong");
        }
    });
});
Parse.Cloud.job("scrapper", function(request, status) {
 
    Parse.Cloud.useMasterKey();
    Parse.Cloud.httpRequest({
        url: 'http://invis.ca/in/about/current-rates/',
        success: function(httpResponse) {
 
            var data = httpResponse.text.split("<table>");
                data = data[1].split("</table>");
                data = data[0].split("<tr>");
 
                var b = 1;
                var requests = 0;
 
            for(var i=3; i<12; i++){
                    requests++;
 
 
                if(i!=10){
 
                    var inside_data = data[i].split("</td>");
                        inside_data = inside_data[2].split(">");
                        inside_data = inside_data[1].slice(0, -1);
                        inside_data = parseFloat(inside_data)/10;
                        inside_data = inside_data.toFixed(10);
                        inside_data = inside_data.substring(0, inside_data.length-7);
 
 
 
                    if(i==11){
                        Parse.Cloud.run('updateRate', {
                            year: b,
                            rate: parseFloat(inside_data),
                            varRate: true
                        }, {
                            success: function(result) {
                                requests--;
                                if(requests==0)
                                    done();
                            },
                            error: function(error) {}
                        });
                    }
                    else {
                        Parse.Cloud.run('updateRate', {
                            year: b,
                            rate: parseFloat(inside_data),
                            varRate: false
                        }, {
                            success: function(result) {
                                requests--;
                                if(requests==0)
                                    done();
                            },
                            error: function(error) {}
                        });
                    }
 
 
                }
 
                    if(b==7)
                        b=10;
                    else if(b==5)
                        b=7;
                    else
                        b++;
 
                    if(i==10)
                        b=5;
                }
 
                function done(){
                    status.success("Success");
                }
 
        },
        error: function(httpResponse) {
            status.error("Uh oh, something went wrong");
        }
    });
});
Parse.Cloud.define("updateRate", function(request, response) {
 
    var Rates = Parse.Object.extend("rates");
    var query = new Parse.Query(Rates);
 
    query.equalTo("years", request.params.year);
    query.first({
        success: function(obj) {
            if(request.params.varRate)
                obj.set("variableRate", request.params.rate);
            else
                obj.set("rate", request.params.rate);
            obj.save(null, {
                success: function(obj){
                   response.success("true");
                }
            });
        }
    });
 
});
Parse.Cloud.beforeSave("_User", function(request, response) {
    var user = request.object;
 
    if (!user.dirty("profileImgLarge") || !user.get("profileImgLarge")) {
        response.success();
        return;
    }
 
//    if(!user.has('referal')){
//        var countQuery = new Parse.Query(Parse.User);
//        countQuery.equalTo("referal", user.get('referal'));
//        countQuery.count({
//            success : function(count) {
//                if(count>=3){
//                    response.error("Limit reach");
//                }
//            }
//        });
//    }
 
    Parse.Cloud.httpRequest({
        url: user.get("profileImgLarge")
 
    }).then(function(response) {
            var image = new Image();
            return image.setData(response.buffer);
 
        }).then(function(image) {
            // Crop the image to the smaller of width or height.
            var size = Math.min(image.width(), image.height());
            return image.crop({
                left: (image.width() - size) / 2,
                top: (image.height() - size) / 2,
                width: size,
                height: size
            });
 
        }).then(function(image) {
            return image.scale({
                width: 125,
                height: 125
            });
 
        }).then(function(image) {
            return image.setFormat("JPEG");
 
        }).then(function(image) {
            return image.data();
 
        }).then(function(buffer) {
            var base64 = buffer.toString("base64");
            var cropped = new Parse.File("thumbnail.jpg", { base64: base64 });
            return cropped.save();
 
        }).then(function(cropped) {
            user.set("profileImg", cropped);
 
        }).then(function(result) {
            response.success();
        }, function(error) {
            response.error(error);
        });
});
Parse.Cloud.afterSave("List", function(request, response) {
    var list = request.object;
    var user = Parse.User.current();
    if (list.existed()) {
        return;
    }
    var roleName = "membersOf_" + list.id;
 
    var listRole = new Parse.Role(roleName, new Parse.ACL(user));
    listRole.relation("users").add(user);
    if(user.has('referal'))
        listRole.relation("users").add(user.get('referal'));
 
 
    var queryRole = new Parse.Query(Parse.Role);
    queryRole.equalTo('name', "Administrator");
    queryRole.first().then(
        function(result){
            listRole.relation("roles").add(result);
 
            return listRole.save().then(function(listRole) {
                var acl = new Parse.ACL();
                acl.setPublicReadAccess(false);
                acl.setPublicWriteAccess(false);
                acl.setReadAccess(listRole, true);
                acl.setWriteAccess(listRole, true);
                acl.setRoleReadAccess("Administrator", true);
                acl.setRoleWriteAccess("Administrator", true);
 
                var itemData = new Parse.Object("List", {
                    ACL: acl
                });
                return itemData.save('objectId', list.id);
            });
        }
    )
 
});
Parse.Cloud.beforeSave("Applications", function(request, response) {
    var item = request.object,
        listId = request.object.get("list"),
        oldStatus,
        newStatus = item.get("ApplicationStatus"),
        sendActivity = false,
        addRebate = false,
        user = Parse.User.current();
 
    if ((item.has("Personal1Fname") && item.has("Personal1Lname")) && (item.dirty("Personal1Fname") || item.dirty("Personal1Lname")) ) {
        item.set("searchName", item.get("Personal1Fname").toLowerCase()+" "+item.get("Personal1Lname").toLowerCase())
    }
 
        if (item.dirty("ApplicationStatus") ) {
 
            if(item.get("ApplicationStatus")==0)
                item.set("submited", false);
 
            if(item.has("ApplicationStatusOld")){
                oldStatus = item.get("ApplicationStatusOld");
                if(oldStatus!=newStatus)
                    sendActivity = true;
                if(oldStatus>0 && newStatus == 0)
                    newStatus = 6;
            }
            else
                sendActivity = true;
 
            if(newStatus == 5 && !item.has("rebateUsed")){
                addRebate = true;
                item.set("rebateUsed", true);
            }
 
            item.set("ApplicationStatusOld", item.get("ApplicationStatus"));
 
            if(sendActivity && item.has("user")){
                Parse.Cloud.run('AddActivity', {
                    status: newStatus,
                    addRebates: addRebate,
                    user:   item.get("user").id,
                    appId:  item.get("refId")
                });
 
                if(addRebate){
                    var applicationRebates = parseInt(item.get("CashBack"));
                    var query = new Parse.Query(Parse.User);
                    query.get(item.get("user").id, {
                        success: function(rUser) {
                            var rebate = parseInt(rUser.get("rebates"));
                            rUser.set("rebates", rebate+applicationRebates);
                            rUser.save();
                        }
                    });
                }
 
            }
            else if(sendActivity && !item.has("user")){
                Parse.Cloud.run('AddActivityBlank', {
                    status: newStatus,
                    addRebates: addRebate,
                    email: item.get("Personal1Email"),
                    name: item.get("Personal1Fname")+" "+item.get("Personal1Lname"),
                });
            }
        }
 
 
            var acl = new Parse.ACL();
            acl.setPublicReadAccess(false);
            acl.setPublicWriteAccess(false);
 
            if(item.has("user")){
                acl.setRoleWriteAccess("membersOf_" + listId, true);
                acl.setRoleReadAccess("membersOf_" + listId,  true);
                item.set('ACL', acl);
                var List = Parse.Object.extend("List");
                var query = new Parse.Query(List);
                query.equalTo("objectId", listId);
                query.first({
                    success: function(list) {
                        if (list.id) {
                            response.success();
                        }
                        else {
                            response.error('No such list or you don\'t have permission to perform this operation.');
                        }
                    },
                    error: function(error) {
                        response.error(error);
                    }
                });
            }
            else {
                acl.setRoleWriteAccess("Administrator", true);
                acl.setRoleReadAccess("Administrator",  true);
                item.set('ACL', acl);
                response.success();
            }
 
});
Parse.Cloud.define("AddActivity", function(request, response) {
    Parse.Cloud.useMasterKey();
 
    var messages = [
            "##NAME## application was started ##TIME##. ##LINK##",
            "##NAME## application was submitted ##TIME##. ##LINK##",
            "##NAME## application was received ##TIME##. ##LINK##",
            "##NAME## application is Under Review ##TIME##. ##LINK##",
            "##NAME## application was approved ##TIME##. ##LINK##",
            "##NAME## application has been Completed! ##TIME##. ##LINK##",
            "##NAME## application was edited ##TIME##. ##LINK##"
    ];
 
    var messagesR = [
        "Great news, ##NAME## has started their application, but has not yet completed it.",
        "##NAME## has submitted their applicationhas submitted an application with Do Your Own Mortgage",
        "Your referral's ##NAME## application was received and is now on it's way to approval. ##TIME##. ##LINK##",
        "Your referral's ##NAME##  application is Under Review. ##TIME##. ##LINK##",
        "Your referral's ##NAME##  application was approved.",
        "Great news, ##NAME## got her mortgage done with Do Your Own Mortgage!  You will receive an  E-Transfer within 15 business days from today’s date.Once again, thank you for your referral! ##TIME##.",
        "Your referral ##NAME## is still working on their application.  ##TIME##. ##LINK##"
    ];
 
    var subjects = [
        "",
        "",
        "Your application was received.",
        "Your Application is Under Review",
        "Your application was approved.",
        "Your Application has been Completed!"
    ];
 
    var alerts = [
        "alert-warning",
        "alert-warning",
        "alert-info",
        "alert-info",
        "alert-info",
        "alert-success",
        "alert-warning"
    ];
 
    var templates = [
        "",
        "",
        "received",
        "pending",
        "approved",
        "completed"
    ];
 
    var time = Math.round(new Date().getTime() / 1000);
    var _Activity = Parse.Object.extend("Activity");
 
    var userQuery = new Parse.Query(Parse.User);
    userQuery.equalTo("objectId", request.params.user);
    userQuery.first({
        success: function(results) {
            var user = results;
 
            if(request.params.status<7){
                var activity = new _Activity();
                activity.set("message", messages[request.params.status]);
                activity.set("alert", alerts[request.params.status])
                var regex = [
                    {
                        key: "##NAME##",
                        text: "Your"
                    },
                    {
                        key: "##TIME##",
                        text: '<span data-livestamp="'+time+'"></span>'
                    },
                    {
                        key: "##LINK##",
                        text: "<a href='/dashboard/my-application-status'>View status.</a> "
                    }
                ];
                activity.set("regex", regex);
                activity.set("user", user);
 
                activity.save({
                        success: function(results) {
 
                            if(request.params.status>=2 && request.params.status<6){
                                Parse.Cloud.run('sendMailActivity', {
                                    template: templates[request.params.status],
                                    subject:  subjects[request.params.status],
                                    email: user.get("email"),
                                    name: user.get("firstName")+" "+user.get("lastName"),
                                    merges: [
                                        {
                                            "name": "name",
                                            "content": user.get("firstName")
                                        },
                                        {
                                            "name": "aid",
                                            "content": request.params.appId
                                        }
                                    ]
                                });
                            }
 
                            if(user.has("referal")){
 
                                var activity = new _Activity();
                                activity.set("message", messagesR[request.params.status]);
                                activity.set("alert", alerts[request.params.status])
                                var regex = [
                                    {
                                        key: "##NAME##",
                                        text: user.get("firstName")+" "+user.get("lastName")
                                    },
                                    {
                                        key: "##TIME##",
                                        text: '<span data-livestamp="'+time+'"></span>'
                                    },
                                    {
                                        key: "##LINK##",
                                        text: "<a href='/dashboard/my-referal-status/"+user.id+"'>View status.</a> "
                                    },
                                    {
                                        key: "##ADDRESS##",
                                        text: user.get("referal").get("address")+" "+user.get("referal").get("address2")+" "+user.get("referal").get("postal")+","+user.get("referal").get("city")+" "+user.get("referal").get("province"),
                                    },
                                    {
                                        key: "##LINKADDRESS##",
                                        text: "<a href='/dashboard/edit-profile'>Edit your address</a> "
                                    }
                                ];
                                activity.set("regex", regex);
                                activity.set("user", user.get("referal"));
                                activity.save({
                                    success: function(results) {
 
 
                                       if(request.params.addRebates){
 
                                            var activity = new _Activity();
                                            activity.set("message", messages[5]);
                                            activity.set("alert", alerts[5])
                                            var regex = [
                                                {
                                                    key: "##NAME##",
                                                    text: "You"
                                                },
                                                {
                                                    key: "##TIME##",
                                                    text: '<span data-livestamp="'+time+'"></span>'
                                                },
                                                {
                                                    key: "##LINK##",
                                                    text: "<a href='/dashboard/my-referal-status/"+user.id+"'>View status.</a> "
                                                }
                                            ];
                                            activity.set("regex", regex);
                                            activity.set("user", user.get("referal"));
                                            activity.save({
                                                success: function(results) {
 
                                                    var query = new Parse.Query(Parse.User);
                                                    query.get(user.get("referal").id, {
                                                        success: function(rUser) {
                                                            rUser.set("rebates", rUser.get("rebates")+500);
                                                            rUser.save().then(function(){
                                                                response.success();
                                                            });
                                                        }
                                                    });
 
 
                                                },
                                                error: function(error){
                                                    response.error(error);
                                                }});
                                        }
                                        else
                                            response.success();
                                    },
                                    error: function(error){
                                        response.error(error);
                                }});
                            }
                            else
                                response.success();
                        },
                    error: function(error){
                        response.error(error);
                    }});
 
            }
 
        },
        error: function(error){
            response.error(error);
        }
    });
});
Parse.Cloud.define("AddActivityBlank", function(request, response) {
    Parse.Cloud.useMasterKey();
 
    var messages = [
        "##NAME## application was started ##TIME##. ##LINK##",
        "##NAME## application was completed ##TIME##. ##LINK##",
        "##NAME## application was accepted ##TIME##. ##LINK##",
        "##NAME## application was approved ##TIME##. ##LINK##",
        "##NAME## application was edited ##TIME##. ##LINK##",
        "##NAME## received $500 rebates ##TIME##. ##LINK##"
    ];
 
    var alerts = [
        "alert-warning",
        "alert-success",
        "alert-info",
        "alert-success",
        "alert-warning",
        "alert-info"
    ];
 
    var subjects = [
        "",
        "",
        "Your application was confirmed.",
        "Your application was approved."
    ];
 
    var templates = [
        "",
        "",
        "confirmed",
        "approved"
    ];
 
    var time = Math.round(new Date().getTime() / 1000);
 
    if(request.params.status>1 && request.params.status<4){
        Parse.Cloud.run('sendMailActivity', {
            template: templates[request.params.status],
            subject:  subjects[request.params.status],
            email: request.email,
            name: request.name,
            merges: [
                {
                    "name": "name",
                    "content": request.name
                },
                {
                    "name": "aid",
                    "content": "ID"
                }
            ]
        });
    }
 
});
Parse.Cloud.define("getUserSessionToken", function(request, response) {
 
    Parse.Cloud.useMasterKey();
 
    var id = request.params.user;
 
    var query = new Parse.Query(Parse.User);
    query.equalTo("objectId", id);
    query.limit(1);
    query.find({
        success: function(user) {
            response.success(user[0].getSessionToken());
        },
        error: function(error) {
            response.error(error.description);
        }
    });
 
});
Parse.Cloud.define("addToRole", function(request, response) {
 
    Parse.Cloud.useMasterKey();
 
    if(Parse.User.current()){
 
        var queryRole = new Parse.Query(Parse.Role);
        queryRole.equalTo('name', "Administrator");
        queryRole.first({
            success: function(result) {
                var adminRelation = new Parse.Relation(result, 'users');
                var queryAdmins = adminRelation.query();
 
                queryAdmins.equalTo('objectId', Parse.User.current().id);
                queryAdmins.first({
                    success: function(result) {
                        var rsp = result ? true : false;
                        if(rsp){
                            var email = request.params.email;
 
                            var query = new Parse.Query(Parse.User);
                            query.equalTo("email", email);
                            query.limit(1);
                            query.first({
                                success: function(user) {
 
                                    var queryRole = new Parse.Query(Parse.Role);
                                    queryRole.equalTo('name', "Administrator");
                                    queryRole.first().then(
                                        function(role){
                                            role.relation("users").add(user);
                                            role.save();
                                            response.success(user);
                                        }
                                    )
 
                                },
                                error: function(error) {
                                    response.error(error.description);
                                }
                            });
                        }
                        else
                            response.error();
                    }
                });
 
            },
            error: function(error) {
                response.error();
            }
        });
 
    }
    else
        response.error();
 
});
Parse.Cloud.define("getAdmins", function(request, response) {
    if(Parse.User.current()){
 
        var queryRole = new Parse.Query(Parse.Role);
        queryRole.equalTo('name', "Administrator");
        queryRole.first({
            success: function(result) {
                var adminRelation = new Parse.Relation(result, 'users');
                var queryAdmins = adminRelation.query();
 
                queryAdmins.equalTo('objectId', Parse.User.current().id);
                queryAdmins.first({
                    success: function(result) {
                        var rsp = result ? true : false;
                        if(rsp){
                            var queryRole = new Parse.Query(Parse.Role);
                            queryRole.equalTo('name', "Administrator");
                            queryRole.first({
                                success: function(result) {
                                    var adminRelation = new Parse.Relation(result, 'users');
                                    var queryAdmins = adminRelation.query();
                                    queryAdmins.find({
                                        success: function(result) {
                                            response.success(result);
                                        },
                                        error: function(error) {
                                            response.error(error.description);
                                        }
                                    });
 
                                },
                                error: function(error) {
                                    response.error(error.description);
                                }
                            });
                        }
                        else
                            response.error();
                    }
                });
 
            },
            error: function(error) {
                response.error();
            }
        });
 
    }
    else
        response.error();
 
});
Parse.Cloud.define("removeAdmin", function(request, response) {
 
    if(Parse.User.current()){
 
        var queryRole = new Parse.Query(Parse.Role);
        queryRole.equalTo('name', "Administrator");
        queryRole.first({
            success: function(result) {
                var adminRelation = new Parse.Relation(result, 'users');
                var queryAdmins = adminRelation.query();
 
                queryAdmins.equalTo('objectId', Parse.User.current().id);
                queryAdmins.first({
                    success: function(result) {
                        var rsp = result ? true : false;
                        if(rsp){
 
                            var id = request.params.user;
 
                            var query = new Parse.Query(Parse.User);
                            query.equalTo("objectId", id);
                            query.limit(1);
                            query.first({
                                success: function(user) {
 
                                    var queryRole = new Parse.Query(Parse.Role);
                                    queryRole.equalTo('name', "Administrator");
                                    queryRole.first().then(
                                        function(role){
                                            role.relation("users").remove(user);
                                            role.save();
                                            response.success();
                                        }
                                    )
 
                                },
                                error: function(error) {
                                    response.error(error.description);
                                }
                            });
                        }
                        else
                            response.error();
                    }
                });
 
            },
            error: function(error) {
                response.error();
            }
        });
 
    }
    else
        response.error();
 
});
Parse.Cloud.define("sendMailActivity", function(request, response) {
    Mandrill.sendTemplate(request.params.template, {}, {
            auto_html: true,
            auto_text: true,
            subject: request.params.subject,
            from_email: "noreply@doyourownmortgage.com",
            from_name: "Do Your Own Mortgage",
            merge: true,
            merge_vars: [
                {
                    "rcpt": request.params.email,
                    "vars": request.params.merges
                }
            ],
            to: [
                {
                    email: request.params.email,
                    name: request.params.name
                }
            ]
        },
        true
    ).then(function(){
            response.success("Email sent!");
    });
 
});
Parse.Cloud.define("checkIfExistRid", function(request, response) {
    var Application = Parse.Object.extend("Applications");
    var query = new Parse.Query(Application);
    query.equalTo("refId", request.params.rid);
    query.count().then(function(count){
        response.success(count===0);
    });
});
Parse.Cloud.define("getRefId", function(request, response) {
    var getId = function(){
        var text = "",
            possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
            posibleSecond = "0123456789";
 
        for( var i=0; i < 6; i++ ){
            if(i<2)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            else
                text += posibleSecond.charAt(Math.floor(Math.random() * posibleSecond.length));
        }
 
        return text;
    };
    function init(){
        var rid = getId();
        Parse.Cloud.run('checkIfExistRid', {
            rid: rid
        }).then(function(exist){
                if(exist)
                    response.success(rid);
                else
                    init();
        });
    }
    init();
});