window.onload=function() {
tab.setup = {
   tabs: document.getElementById('tab_nav').getElementsByTagName('li'),
   pages: [
      document.getElementById('seo'),
      document.getElementById('othe'),
   ]
}
tab.init();
}
var tab = {
	init: function(){
		var tabs = this.setup.tabs;
		var pages = this.setup.pages;
		
		for(i=0; i<pages.length; i++) {
			if(i !== 0) pages[i].style.display = 'none';
			tabs[i].onclick = function(){ tab.showpage(this); return false; };
		}
		this.dive();
	},
	
	showpage: function(obj){
		var tabs = this.setup.tabs;
		var pages = this.setup.pages;
		var num;
		
		for(num=0; num<tabs.length; num++) {
			if(tabs[num] === obj) break;
		}
		
		for(var i=0; i<pages.length; i++) {
			if(i == num) {
				pages[num].style.display = 'block';
				tabs[num].className = 'present';
			}
			else{
				pages[i].style.display = 'none';
				tabs[i].className = null;
			}
		}
	},

	dive: function(){
		var hash = window.location.hash;
		hash = hash.split("?");
		hash = hash[0].split("#");

		var tabs = this.setup.tabs;
		var pages = this.setup.pages;
		for(i=0; i<pages.length; i++) {
			if(pages[i] == document.getElementById(hash[1])) this.showpage(tabs[i]);
		}
	}
}