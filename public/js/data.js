var menuData = {
	add: function(){
		var form_data = {
			name: $("#name").val(),
			tag: $("#sendTag").val(),
			team: $("#team").val()
		};

		$.ajax({
			type: "POST",
			url: "/menu/add",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
				else location.reload();
			}
		});
	},
	update: function(){
		var form_data = {
			name: $("#name").val(),
			tag: $("#sendTag").val(),
			idx: $("#menuIdx").val()
		};

		$.ajax({
			type: "POST",
			url: "/menu/update",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
				else location.reload();
			}
		});
	},
	select: function(menu){
		var form_data = {
			menu: menu,
			team: $("#team").val()
		};

		$.ajax({
			type: "POST",
			url: "/menu/select",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
				else location.reload();
			}
		});
	}
}

var teamData = {
	add: function(){
		var form_data = {
			name: $("#name").val(),
			desc: $("#desc").val(),
			url: $("#url").val()
		};

		$.ajax({
			type: "POST",
			url: "/team/add",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
				else location.reload();
			}
		});
	}
}

var inviteData = {
	add: function(){
		var form_data = {
			userid: $("#join_user").val(),
			team : $("#team").val()
		};

		$.ajax({
			type: "POST",
			url: "/team/invite",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
				else location.reload();
			}
		});
	},
	agree: function(target){
		var form_data = {
			team : $(target).find(".team").val()
		};

		$.ajax({
			type: "POST",
			url: "/team/invite_agree",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
				else location.reload();
			}
		});
	}
}

var chooseData = {
	choose: function(menuIdx){
		var form_data = {
			menuIdx: menuIdx,
			team: $("#team").val()
		};

		$.ajax({
			type: "POST",
			url: "/menu/choose",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
			}
		});
	},
	cancel: function(menuIdx){
		var form_data = {
			menuIdx: menuIdx,
			team: $("#team").val()
		};

		$.ajax({
			type: "POST",
			url: "/menu/cancel",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
			}
		});
	}
}

var userData = {
	password: function(){
		var form_data = {
			nowPw: $("#nowPw").val(),
			newPw: $("#newPw").val(),
			newPw2: $("#newPw2").val()
		};

		$.ajax({
			type: "POST",
			url: "/user/uiu",
			data: form_data,
			success: function(data) {
				if(data) alert(data);
				else{
					alert("변경되었어요!");
					location.reload();
				}
			}
		});
	}
}