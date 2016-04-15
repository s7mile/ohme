var menuData = {
	add: function(){
		var form_data = {
			name: $("#name").val(),
			tag: $("#sendTag").val(),
			team_idx: 1
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
	}
}

var teamData = {
	add: function(){
		var form_data = {
			name: $("#name").val(),
			desc: $("#desc").val()
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

var chooseData = {
	choose: function(menuIdx){
		var form_data = {
			menuIdx: menuIdx
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
			menuIdx: menuIdx
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