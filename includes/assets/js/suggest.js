class Suggest {
	
	constructor(){
		this.input = '' ;
		this.box = '' ;
		this.url = '' ;
		this.delay = 500 ;
		this.minlength = 2 ;
		this.timer = null ;
	}


	// ATTACH AUTO-COMPLETE TO TARGET ELEMENT
	init(opt = {}){
		var s = this;
		this.input = document.getElementById(opt.target);
		// console.log(this.input);
		this.box = document.getElementById(opt.box);
		if (opt.delay) { this.delay = opt.delay; }
		if (opt.minlength) { this.minlength = opt.minlength; }
		if (opt.url) { this.url = opt.url; }
		this.input.addEventListener("keyup", function(){
			if (s.timer!=null) { window.clearTimeout(s.timer); }
			s.timer = setTimeout(function(){
				
				if (s.input.value.length >= s.minlength) {
					var req = new XMLHttpRequest();
					req.addEventListener("load", function(){
						s.draw(JSON.parse(this.responseText));
					});
					req.open("GET", s.url + "?term=" + s.input.value);
					req.send();
				}
				else{
					s.box.innerHTML='';
				}

			}, s.delay);
		});
		}


	// DRAW SUGGESTION BOX
	draw(data){
		var s=this;
		this.box.innerHTML = "";
		if (data.length>0) { data.forEach(function(el){
			s.box.insertAdjacentHTML('beforeend', '<option value="'+ el +'">');
		});}
	}

	autoComplete(targetName, boxName, completeURL){
		this.init({
			target : targetName,
			box : boxName,
			url : "http://localhost/healthcare/includes/handlers/ajax/" + completeURL,
			delay : 400,
			minlength : 2
		});		
	}

}

