app.controller('mainCtrl', function ($scope, $route, $routeParams, $rootScope, $window, $location, $timeout, $_global, cons) {
	$scope.path = cons.path;
	$scope.text = cons.text;
	$scope.dataSTN = [];
	$scope.dataREAL = [];
	$scope.dataCCTV = [];
	$scope.events = [];
	$scope.glued = true;
	$scope.bell = "fa-bell-o";
	$scope.soundEnable = true;
	$_global.request($scope.path.json.station).then(function successCallback(response) {
		$scope.dataSTN = response.data.station;
		angular.forEach($scope.dataSTN, function (value, key) {
			var rf_value = null;
			var wl_up_value = null;
			var wl_down_value = null;
			var rf_status = "white";
			var wl_up_status = "white";
			var wl_down_status = "white";
			var rf_update = false;
			var wl_up_update = false;
			var wl_down_update = false;
			if (value['data']['rf']['enable']) {
				rf_value = parseFloat(value['data']['rf']['value']['now']);
				rf_status = value['data']['rf']['value']['status'];
				if (rf_status !== "success") {
					rf_update = true;
					$scope.events.push({
						date: value['date'],
						name: value['code'] + ' ' + value['name'],
						detail: $scope.eventSMS(value['data']['rf']['value'], 'ปริมาณฝน'),
						status: rf_status
					});
				}
			}
			if (value['data']['wl_up']['enable']) {
				wl_up_value = parseFloat(value['data']['wl_up']['value']['now']);
				wl_up_status = value['data']['wl_up']['value']['status'];
				if (wl_up_status !== "success") {
					wl_up_update = true;
					$scope.events.push({
						date: value['date'],
						name: value['code'] + ' ' + value['name'],
						detail: $scope.eventSMS(value['data']['wl_up']['value'], 'ระดับน้ำ'),
						status: wl_up_status
					});
				}
			}
			if (value['data']['wl_down']['enable']) {
				wl_down_value = parseFloat(value['data']['wl_down']['value']['now']);
				wl_down_status = value['data']['wl_down']['value']['status'];
				if (wl_down_status !== "success") {
					wl_down_update = true;
					$scope.events.push({
						date: value['date'],
						name: value['code'] + ' ' + value['name'],
						detail: $scope.eventSMS(value['data']['wl_down']['value'], 'ระดับน้ำ(ท้าย)'),
						status: wl_down_status
					});
				}
			}
			if ([rf_update, wl_up_update, wl_down_update].indexOf(true) > -1) {
				$scope.sound('play');
			}
			$scope.dataREAL.push({
				id: value['id'],
				code: value['code'],
				zone: value['zone'],
				date: value['date'],
				rf: {
					value: rf_value,
					status: rf_status,
					update: rf_update
				},
				wl_up: {
					value: wl_up_value,
					status: wl_up_status,
					update: wl_up_update
				},
				wl_down: {
					value: wl_down_value,
					status: wl_down_status,
					update: wl_down_update
				},
				door: {
					status: value['door'],
					update: false
				}
			});
			angular.forEach(value['cctv'], function (cctv, key) {
				$scope.dataCCTV.push({
					id: value['code'],
					no: key + 1,
					zone: value['zone'],
					name: value['name'],
					src: cctv
				});
			});
		});
	}, function errorCallback(response) {
		console.log(response);
	});
	if ($rootScope.online) {
		$scope.message = '';
		$scope.messages = [];
		$scope.scadaHost = null;
		$.connection.hub.url = $scope.path.signalr;
		$scope.scadaHost = $.connection.scadaHost;
		$.connection.hub.start().done(function () { /*$scope.scadaHost.server.joinGroup("AllStation_RealTime");*/ $scope.scadaHost.server.joinGroup("TagChannel");
		});
		$scope.scadaHost.client.addMessage = function (message) {
			if ($scope.messages.length > 100) {
				$scope.messages = [];
			}
			if ($scope.events.length > 100) {
				$scope.events = [];
			}
			var msg = JSON.parse(message);
			var val = parseFloat(msg.TagValue).toFixed(2) / 1;
			var tag = "",
			wn = "",
			dg = "",
			st = "success",
			selected;
			if (selected = $_global.select($scope.dataSTN, 'id', msg.StationID)) {
				if (selected.data.rf.enable && (msg.TagName == "rf_log" || msg.TagName == "rf_real")) {
					tag = 'ปริมาณฝน';
					wn = selected.data.rf.value.warning;
					dg = selected.data.rf.value.danger;
					st = (val >= wn) ? 'warning' : st;
					st = (val >= dg) ? 'danger' : st;
				}
				if (selected.data.wl_up.enable && (msg.TagName == "wl1_real" || msg.TagName == "wl1_log")) {
					tag = 'ระดับน้ำ';
					wn = selected.data.wl_up.value.warning;
					dg = selected.data.wl_up.value.danger;
					st = (val >= wn) ? 'warning' : st;
					st = (val >= dg) ? 'danger' : st;
				}
				if (selected.data.wl_down.enable && (msg.TagName == "wl2_real" || msg.TagName == "wl2_log")) {
					tag = 'ระดับน้ำ (ท้าย)';
					wn = selected.data.wl_down.value.warning;
					dg = selected.data.wl_down.value.danger;
					st = (val >= wn) ? 'warning' : st;
					st = (val >= dg) ? 'danger' : st;
				}
				if (msg.TagName == "alarm_door") {
					tag = 'ประตู';
					val = msg.TagValue;
				}
				if (tag != '') {
					var obj = {
						id: msg.StationID,
						code: selected.code,
						name: selected.name,
						date: msg.TimeStamp,
						tag: tag,
						param: msg.TagName,
						stats: st,
						value: val,
						warning: wn,
						danger: dg
					};
					$scope.messages.push(obj);
					$scope.update(obj);
					$scope.$apply();
				}
			}
		};
	}
	$scope.update = function (data) {
		var keepGoing = true;
		angular.forEach($scope.dataREAL, function (value, key) {
			if (keepGoing && data.id == value['id']) {
				if (data.param == "rf_log" || data.param == "rf_real") {
					if ($scope.dataREAL[key].rf.status !== data.stats && data.stats !== "success") {
						$scope.dataREAL[key].rf.update = true;
						$scope.events.push({
							date: data.date,
							name: value['code'] + ' ' + data.name,
							detail: $scope.eventSMS({
								now: data.value,
								warning: data.warning,
								danger: data.danger
							}, 'ปริมาณฝน'),
							status: data.stats
						});
						$scope.sound('play');
					} else {
						$scope.dataREAL[key].rf.update = false;
					}
					$scope.dataREAL[key].rf.value = data.value;
					$scope.dataREAL[key].rf.status = data.stats;
					$scope.dataREAL[key].date = data.date;
				} else if (data.param == "wl1_real" || data.param == "wl1_log") {
					if ($scope.dataREAL[key].wl_up.status !== data.stats && data.stats !== "success") {
						$scope.dataREAL[key].wl_up.update = true;
						$scope.events.push({
							date: data.date,
							name: value['code'] + ' ' + data.name,
							detail: $scope.eventSMS({
								now: data.value,
								warning: data.warning,
								danger: data.danger
							}, 'ปริมาณฝน'),
							status: data.stats
						});
						$scope.sound('play');
					} else {
						$scope.dataREAL[key].wl_up.update = false;
					}
					$scope.dataREAL[key].wl_up.value = data.value;
					$scope.dataREAL[key].wl_up.status = data.stats;
					$scope.dataREAL[key].date = data.date;
				} else if (data.param == "wl2_real" || data.param == "wl2_log") {
					if ($scope.dataREAL[key].wl_down.status !== data.stats && data.stats !== "success") {
						$scope.dataREAL[key].wl_down.update = true;
						$scope.events.push({
							date: data.date,
							name: value['code'] + ' ' + data.name,
							detail: $scope.eventSMS({
								now: data.value,
								warning: data.warning,
								danger: data.danger
							}, 'ปริมาณฝน'),
							status: data.stats
						});
						$scope.sound('play');
					} else {
						$scope.dataREAL[key].wl_down.update = false;
					}
					$scope.dataREAL[key].wl_down.value = data.value;
					$scope.dataREAL[key].wl_down.status = data.stats;
					$scope.dataREAL[key].date = data.date;
				} else if (data.param == "alarm_door") {
					$scope.dataREAL[key].door.status = (data.value.toLowerCase() == "true") ? true : false;
				}
				keepGoing = false;
			}
		});
	};
	$scope.eventSMS = function (data, tag) {
		var val = parseFloat(data.now);
		var txt;
		if (val >= data.warning) {
			txt = tag + 'อยู่ในเกณฑ์เฝ้าระวัง (' + data.warning + ') วัดได้ ' + val;
		} else if (val >= data.danger) {
			txt = tag + 'อยู่ในเกณฑ์วิกฤติ (' + data.danger + ') วัดได้ ' + val;
		} else {
			txt = 'สัญญาณเชื่อมต่อไม่ดีหรืออาจขัดข้อง';
		}
		return txt;
	};
	$scope.sound = function (mode) {
		switch (mode) {
		case 'play':
			if ($scope.soundEnable) {
				//$('#audio')[0].play();
			}
			break;
		case 'mute':
			if ($scope.bell == "fa-bell-o") {
				$scope.bell = "fa-bell-slash-o text-fade";
				$scope.soundEnable = false;
			} else {
				$scope.bell = "fa-bell-o";
				$scope.soundEnable = true;
			}
			break;
		default:
		}
	};
	$scope.dateUTC = function (dt) {
		var dateObj = new Date();
		var dateNew = dateObj.getUTCFullYear() + "-" + (dateObj.getUTCMonth() + 1) + "-" + dateObj.getUTCDate() + " " + dateObj.getHours() + ":" + dateObj.getMinutes();
		var d = (dt) ? dt : dateNew;
		var a = d.split(/[^0-9]/);
		if (a[5]) {
			return Date.UTC(a[0], a[1] - 1, a[2], a[3], a[4], a[5]);
		} else {
			return Date.UTC(a[0], a[1] - 1, a[2], a[3], a[4]);
		}
	};
	$scope.convIcon = function (bool, type) {
		var style = "";
		if (type == "door") {
			style = (bool) ? "fa-lock text-success" : "fa-unlock text-fade";
		} else {
			style = (bool) ? "text-success" : "text-fade";
		}
		return style;
	};
	$scope.calcDate = function (d1, d2, range) {
		var date1 = new Date(d1);
		var date2 = new Date();
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		var minDiff = Math.floor(timeDiff / 1000 / 60); /*console.log(minDiff);*/ if (minDiff < range) {
			return true;
		} else {
			return false;
		}
	};
	$scope.isActive = function (view) {
		if (view === $location.path() || view === '/' + $location.path().split('/')[1]) {
			return true;
		}
	};
	$scope.scrollField = function (id) {
		var x = (id) ? $("#" + id).offset().top - 110 : 0;
		$('html, body').animate({
			scrollTop: x
		}, 500);
	};
	$scope.loader = function (status) {
		$('loader').show();
		if (status) {
			$timeout(function () {
				$('loader').fadeOut();
			}, 2000);
		}
	};
	$scope.fullscreen = function () {
		var element = document.documentElement;
		if (element.requestFullscreen) {
			element.requestFullscreen();
		} else if (element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		} else if (element.webkitRequestFullscreen) {
			element.webkitRequestFullscreen();
		} else if (element.msRequestFullscreen) {
			element.msRequestFullscreen();
		}
	};
	$scope.exit = function () {
		alert('Do you want to exit?');
		var p = $window.location.href;
		p = p.split('#')[0];
		$window.location = p + "?sign=out";
	};
	$scope.$watch('online', function (newStatus) {
		$scope.loader(newStatus);
		$scope.txtOnline = cons.text.error.conn;
	});
});
app.controller('mapCtrl', function ($scope, $rootScope, $timeout, $_global) {
	var scope = this;
	scope.active = null;
	scope.basket = [];
	scope.basketMax = 4;
	scope.stack = "";
	scope.pop = function (id) {
		$scope.popid = id;
		scope.show = true;
		scope.active = id;
	};
	scope.pin = function (type, data, id) {
		var real = $_global.select($scope.dataREAL, 'code', id);
		var p = s1 = s2 = s3 = null;
		var s = "success";
		p = (type == "A") ? "fa-map-marker" : null;
		p = (type == "B") ? "fa-circle" : p;
		p = (type == "C") ? "fa-car" : p;
		s1 = (data.rf.enable) ? real.rf.status : s1;
		s2 = (data.wl_up.enable) ? real.wl_up.status : s2;
		s3 = (data.wl_down.enable) ? real.wl_down.status : s3;
		s = ([s1, s2, s3].indexOf("warning") > -1) ? "warning" : s;
		s = ([s1, s2, s3].indexOf("danger") > -1) ? "danger" : s;
		s = ([s1, s2, s3].indexOf("black") > -1) ? "black" : s;
		s = ([s1, s2, s3].indexOf("gray") > -1) ? "gray" : s;
		s = ([s1, s2, s3].indexOf("white") > -1) ? "white" : s;
		return p + " text-" + s + " sd-" + s;
	};
	scope.genrBTN = function (code) {
		var x = false;
		if (scope.basket.length < scope.basketMax) {
			x = true;
			$.grep(scope.basket, function (e) {
				x = (e.id == code) ? false : x;
			});
		}
		return x;
	};
	scope.addBasket = function (id, name) {
		scope.basket.push({
			id: id,
			name: name
		});
	};
	scope.removeBasket = function (key) {
		scope.basket.splice(key, 1);
	};
	scope.stack = function () {
		return $_global.stack(scope.basket, 'id');
	};
});
app.controller('popCtrl', function ($scope, $location, $timeout, $_global) {
	var scope = this;
	scope.swap = 0;
	scope.genrID = function (code, length, n) {
		var a = (length > 1) ? "-" + (n + 1) : "";
		return code + a;
	};
	scope.getID = function (code) {
		scope.selected = $_global.select($scope.dataSTN, 'code', code);
		scope.real = $_global.select($scope.dataREAL, 'code', code);
		scope.timeout = $scope.convIcon($scope.calcDate(scope.real.date, null, 60), '');
		scope.door = $scope.convIcon(scope.real.door.status, 'door');
	};
	$timeout(function () {
		if (angular.isDefined($scope.popid)) {
			scope.getID($scope.popid);
		}
	}, 3000);
	$scope.$watch('popid', function (newValue, oldValue) {
		if (newValue != oldValue) {
			scope.getID(newValue);
			scope.swap = 0;
		}
	});
});
app.controller('stnCtrl', function ($scope, $routeParams) {
	$('console').hide();
	var scope = this;
	scope.hide = true;
	scope.id = $routeParams.id.split("-");
	scope.col = "col-sm-" + (12 / scope.id.length);
});
app.controller('tbCtrl', function ($scope, $_global) {
	var scope = this;
	scope.name = function (id) {
		var selected = $_global.select($scope.dataSTN, 'code', id);
		return id + " " + selected.name;
	};
	scope.door = function (st) {
		return (st == false) ? "fa-unlock text-fade" : "fa-lock text-success";
	};
});
app.controller('cctvCtrl', function ($scope) {
	var scope = this;
	scope.ft = {
		zone: 'A'
	};
	scope.fullscreen = false;
	scope.zone = function (x) {
		scope.ft = {
			zone: x
		};
	};
	scope.zoom = function (src) {
		scope.show = true;
		scope.photo = src;
	};
});
app.controller('cfgCtrl', function ($scope, $window, $timeout, $_global) {
	var scope = this;
	$timeout(function () {
		scope.formData = angular.copy($scope.dataSTN);
		angular.forEach(scope.formData, function (value, key) {
			delete value.zone;
			delete value.address;
			delete value.location;
			delete value.cctv;
			delete value.terrain;
			delete value.door;
			delete value.timeout;
			delete value.date;
		});
	}, 1000);
	scope.update = function () {
		scope.dataPOST = {
			cfg: scope.formData
		};
		$_global.request($scope.path.json.config, scope.dataPOST).then(function successCallback(response) {
			$window.location.reload();
		}, function errorCallback(response) {
			console.log(response);
		});
	};
	scope.reset = function () {
		scope.formData = angular.copy($scope.dataSTN);
	};
});
app.controller('userCtrl', function ($scope) {
	var scope = this;
});
