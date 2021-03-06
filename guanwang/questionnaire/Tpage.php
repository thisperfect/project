<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>感谢页</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="css/questionnaire.css" />
		<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="print">
			<header>
				<p>游戏小调查</p>
			</header>
			<p style="position: absolute;top: calc(50% + 25px);top: -moz-calc(50% + 25px);top: -webkit-calc(50% + 25px);left:50%;text-align: center;transform: translate(-50%,-50%);">您的答卷已经提交，感谢您的参与！</p>
		</div>
		<script type="text/javascript">
			// 自定义弹出层
			function Alert(e,a) {
				$("body").append('<div id="msg"><div class="model"></div><div class="content"><p>提示</p><p>'+e+'</p><button>确定</button></div></div>');
				$("#msg button").on("click",function(){
					if(typeof a === "function" && a!=undefined) { //是函数    其中 FunName 为函数名称
						a();
		           	}
					$("#msg").remove();
				});
				$("#msg .content").css('transform', 'rotate('+Orientation+'deg)');
				$("#msg .content").css('transform-origin', '50% 50%');
			}
			var evt = "onorientationchange" in window ? "orientationchange" : "resize";
			// 旋转角度
			var Orientation = "0";
			window.addEventListener(evt, function() {
				//console.log(evt);
				var width = document.documentElement.clientWidth;
				var height = document.documentElement.clientHeight;
				var print = $('.print');
				//console.log(window.orientation);
				if(window.orientation != undefined){
					if(width > height) {
						Orientation = window.orientation;
						print.width(width);
						print.height(height);
						print.css('top', 0);
						print.css('left', 0);
						print.css('transform', 'none');
						print.css('transform-origin', '50% 50%');
					} else {
						Orientation = window.orientation;
						print.width(height);
						print.height(width);
						print.css('top', "-40%");
						print.css('left', 0 - (height - width) / 2);
						print.css('transform', 'rotate('+window.orientation+'deg)');
						print.css('transform-origin', '50% 50%');
					}
					$("#msg .content").css('transform', 'rotate('+Orientation+'deg)');
					$("#msg .content").css('transform-origin', '50% 50%');
				}else{
					if(width > height) {
						Orientation = "0";
						print.width(width);
						print.height(height);
						print.css('top', 0);
						print.css('left', 0);
						print.css('transform', 'none');
						print.css('transform-origin', '50% 50%');
					} else {
						Orientation = "90";
						print.width(height);
						print.height(width);
						print.css('top', (height - width) / 2);
						print.css('left', 0 - (height - width) / 2);
						print.css('transform', 'rotate(90deg)');
						print.css('transform-origin', '50% 50%');
					}
					$("#msg .content").css('transform', 'rotate('+Orientation+'deg)');
					$("#msg .content").css('transform-origin', '50% 50%');
				}
			}, false);
		</script>
	</body>
</html>
