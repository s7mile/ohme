$.getScript("/public/js/data.js");

$(function(){
	var randomBg = {
		init: function() {
			this.bg();
		},
		bg: function() {
			var random = 1 + Math.floor(Math.random() * 6);
			if(($(location).attr('pathname') == '/login') || ($(location).attr('pathname') == '/signup'))
				$("body").append('<div class="setBg bg'+ random +'"></div>');
		}
	}
	randomBg.init();

	var addTag = {
		func: function() {
			var tagVal = $("#tag").val();
			if(tagVal.length > 0){
				$("#tagList").append("<span>"+ tagVal +"</span>");
				if($("#sendTag").val() == "")
					$("#sendTag").val( tagVal );
				else
					$("#sendTag").val( $("#sendTag").val()+","+tagVal );
				$("#tag").val("");
			}
		}
	}

	var addMenuEvent = {
		init: function() {
			this.open();
			this.updateOpen();
			this.close();
			this.tagEvent();
			this.submit();
		},
		open: function() {
			$(".button.add").on("click", function(){
				$("#addMenu.modal").fadeIn();
				$(".cont #name").focus();
				$("#addMenu h2 span").text("추가");
				$("#addMenu #submit").val("등록");
			});	
		},
		updateOpen: function() {
			$("#menuChoose .other").on("click", function(){
				var selInfo = $(this).prev("a");
				$("#addMenu.modal").fadeIn();
				$(".cont #name").focus();
				$("#menuIdx").val($(this).prev("a").data("menu"));
				$("#addMenu h2 span").text("수정");
				$("#addMenu #name").val($(selInfo).find("h3").text());
				$("#addMenu #tagList").html($(selInfo).find(".tag").html());
				$("#addMenu #submit").val("수정");

				var tag = [];
				$(selInfo).find(".tag span").each(function(){
					tag.push($(this).text());
				});
				$("#sendTag").val(tag.join());
			});	
		},
		close: function() {
			$("#addMenu.modal .bg, #addMenu.modal .close").on("click", function(){
				$("#addMenu.modal").fadeOut();
				$("#menuIdx, #sendTag").val("");
				$("#tagList").html("");
			});	
		},
		tagEvent: function() {
			$("#addTag.button").on("click", function(){
				addTag.func();
			});
			$("#tag").keydown(function (key) {
				if (key.keyCode == 13) {
					addTag.func();
				}
			});
		},
		submit: function() {
			$("#addMenu #submit").on("click", function(){
				if($("#menuIdx").val())
					menuData.update();
				else
					menuData.add();
			});
		}
	}
	addMenuEvent.init();

	var addTeamEvent = {
		init: function() {
			this.open();
			this.close();
			this.submit();
		},
		open: function() {
			$(".button.add").on("click", function(){
				$("#addTeam.modal").fadeIn();
				$(".cont #name").focus();
			});	
		},
		close: function() {
			$("#addTeam.modal .bg, #addTeam.modal .close").on("click", function(){
				$("#addTeam.modal").fadeOut();
			});	
		},
		submit: function() {
			$("#addTeam #submit").on("click", function(){
				teamData.add();
			});
		}
	}
	addTeamEvent.init();

	var inviteMember = {
		init: function() {
			this.invite();
			this.submit();
		},
		invite: function() {
			//초대 동의
			$(".inviteTeam").on("click", function(){
				inviteData.agree($(this));
			});
		},
		submit: function() {
			//멤버 초대하기
			$("#memberSetting #submitBtn").on("click", function(){
				inviteData.add();
			});
		}
	}
	inviteMember.init();

	var mypageEvent = {
		init: function() {
			this.password();
			this.profile();
		},
		password: function() {
			$("#mypageArea #submit").on("click", function(){
				userData.password();
			});
		},
		profile: function() {
			var fileTarget = $("#profile");
			fileTarget.on('change', function(){
				if(window.FileReader){  // modern browser
					var filename = $(this)[0].files[0].name;
					if (!$(this)[0].files[0].type.match(/image\//)) return;
		            var reader = new FileReader();
		            reader.onload = function(e){
		                var src = e.target.result;
		                $(".profileArea span").css({"background": "url("+src+") center no-repeat"})
		            }
		            reader.readAsDataURL($(this)[0].files[0]);
				} 
				else {  // old IE
					var filename = $(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
				}
				
				// 추출한 파일명 삽입
				$(this).next().text(filename);

				$(".profileArea #submit").show();
			});
		}
	}
	mypageEvent.init();

	var chooseMenuEvent = {
		init: function() {
			this.choose();
			this.allSel();
		},
		choose: function() {
			$("#menuChoose .menu").on("click", function(){
				var li = $(this).parent();
				if($(li).hasClass("sel")){
					$(li).removeClass("sel");
					chooseData.cancel($(this).data("menu"));
				}else{
					$(li).addClass("sel");
					chooseData.choose($(this).data("menu"));
				}
			});
		},
		allSel: function() {
			$(".button.allSel").on("click", function(){
				if($(this).data("mode") == "sel"){
					$(this).data("mode", "remove");
					$(this).text("전체선택 취소");
					$("#menuChoose li").addClass("sel");
				}else{
					$(this).data("mode", "sel");
					$(this).text("전체선택");
					$("#menuChoose li").removeClass("sel");
				}
			});
		}
	}
	chooseMenuEvent.init();

	var rouletteEvent = {
		init: function() {
			this.open();
			this.close();
		},
		open: function() {
			$("#selectMenu a").on("click", function(){
				$("#roulArea.modal").fadeIn();
				$(".cont #name").focus();
			});	
		},
		close: function() {
			$("#roulArea.modal .bg, #roulArea.modal .close").on("click", function(){
				$("#roulArea.modal").fadeOut();
			});	
		},
	}
	rouletteEvent.init();

	var dropDownEvent = {
		init: function() {
			this.user();
			this.team();
		},
		user: function() {
			var target = $(".user.dropDown")
			$(".userInfo").on("click", function(){
				if($(target).hasClass("open")){
					$(target).removeClass("open").fadeOut("fast");
				}else{
					$(target).addClass("open").fadeIn("fast");
				}
			});	
		},
		team: function() {
			var target = $("#teamInfo .dropDown")
			$("#teamInfo span").on("click", function(){
				if($(target).hasClass("open")){
					$(target).removeClass("open").fadeOut("fast");
				}else{
					$(target).addClass("open").fadeIn("fast");
				}
			});	
		}
	}
	dropDownEvent.init();

	var tabEvent = {
		init: function() {
			this.tab();
		},
		tab: function() {
			$(".tab a").on("click", function(){
				var li = $(this).parent();
				$(".tabArea").hide();
				$("#" + $(li).data("tab")).show();
				$(".tab li").removeClass("sel");
				$(li).addClass("sel");
			})
		}
	}
	tabEvent.init();

<<<<<<< HEAD
	var mouseoverEvent = {
		init: function() {
			this.userNameShow();
		},
		userNameShow: function() {
			$(".member span").hover(
				function(){
					$(this).next().show();
				},
				function(){
					$(this).next().hide();
				}
			);
		}
	}
	mouseoverEvent.init();
=======
	var loginEvent = {
		init: function() {
			this.login();
		},
		login: function() {
			$(".loginArea #submitBtn").on("click", function(){
				userData.login();
			});
		}
	}
	loginEvent.init();
>>>>>>> fa3efbb5f3a0cdcb5593a8d70c70a1195817e5f6
});