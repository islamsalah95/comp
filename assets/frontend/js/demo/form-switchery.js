$(document)
		.ready(
				function() {
					new Switchery(document.getElementById("demo-sw-default")),
							new Switchery(document
									.getElementById("demo-sw-checked")),
							new Switchery(document
									.getElementById("demo-sw-unchecked"));
					var a = document.getElementById("demo-sw-checkstate"), b = document
							.getElementById("demo-sw-checkstate-field");
					new Switchery(a), b.innerHTML = a.checked,
							a.onchange = function() {
								b.innerHTML = a.checked
							}, new Switchery(document
									.getElementById("demo-sw-blue"), {
								color : "#489eed"
							}), new Switchery(document
									.getElementById("demo-sw-light-blue"), {
								color : "#35b9e7"
							}), new Switchery(document
									.getElementById("demo-sw-green"), {
								color : "#44ba56"
							}), new Switchery(document
									.getElementById("demo-sw-orange"), {
								color : "#f0a238"
							}), new Switchery(document
									.getElementById("demo-sw-red"), {
								color : "#e33a4b"
							}), new Switchery(document
									.getElementById("demo-sw-mint"), {
								color : "#2cd0a7"
							}), new Switchery(document
									.getElementById("demo-sw-purple"), {
								color : "#8669cc"
							}), new Switchery(document
									.getElementById("demo-sw-pink"), {
								color : "#ef6eb6"
							}), new Switchery(document
									.getElementById("demo-sw-clr1"), {
								color : "#489eed"
							}), new Switchery(document
									.getElementById("demo-sw-clr2"), {
								color : "#35b9e7"
							}), new Switchery(document
									.getElementById("demo-sw-clr3"), {
								color : "#44ba56"
							}), new Switchery(document
									.getElementById("demo-sw-clr4"), {
								color : "#f0a238"
							}), new Switchery(document
									.getElementById("demo-sw-clr5"), {
								color : "#e33a4b"
							}), new Switchery(document
									.getElementById("demo-sw-clr6"), {
								color : "#2cd0a7"
							}), new Switchery(document
									.getElementById("demo-sw-clr7"), {
								color : "#8669cc"
							}), new Switchery(document
									.getElementById("demo-sw-clr8"), {
								color : "#ef6eb6"
							}), new Switchery(document
									.getElementById("demo-sw-sz-lg"), {
								size : "large"
							}), new Switchery(document
									.getElementById("demo-sw-sz")),
							new Switchery(document
									.getElementById("demo-sw-sz-sm"), {
								size : "small"
							})
				});