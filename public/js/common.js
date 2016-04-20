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
			this.close();
			this.tagEvent();
			this.submit();
		},
		open: function() {
			$(".button.add").on("click", function(){
				$("#addMenu.modal").fadeIn();
				$(".cont #name").focus();
			});	
		},
		close: function() {
			$("#addMenu.modal .bg, #addMenu.modal .close").on("click", function(){
				$("#addMenu.modal").fadeOut();
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
			$(".inviteTeam").on("click", function(){
				inviteData.agree($(this));
			});
		},
		submit: function() {
			$("#memberSetting #submit").on("click", function(){
				inviteData.add();
			});
		}
	}
	inviteMember.init();

	var mypageEvent = {
		init: function() {
			this.password();
		},
		password: function() {
			$("#mypageArea #submit").on("click", function(){
				userData.password();
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
});