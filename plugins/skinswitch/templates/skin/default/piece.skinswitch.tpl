{literal}
<style type="text/css">
#skinswitch-container{
	background-color: white;
	border: 1px solid black;
	display: block;
	position: absolute;
	top: 0px;
	right: 50%;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 14px;
	padding: 3px 4px;
	z-index: 9999;
}
.skinswitch-item{
	color: black;
	font-weight: normal;
	text-decoration: none;
	display: block;
}
.skinswitch-item-current{
	font-weight: bold;
	text-decoration: underline;
}
.skinswitch-item-hide-noncurrent .skinswitch-item{
	display: none;
}
.skinswitch-item-hide-noncurrent .skinswitch-item.skinswitch-item-current{
	display: block;
}
</style>

<script language="javascript">

(function(){
	
	var ready = function(){
		var rspace = /\s+/, rclass = /[\n\t\r]/g;
		
		function trim(str, charlist){
			var whitespace, l = 0,
				i = 0;
			str += '';
		
			if (!charlist) {
				// default list
				whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
			} else {
				// preg_quote custom list
				charlist += '';
				whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
			}
		
			l = str.length;
			for (i = 0; i < l; i++) {
				if (whitespace.indexOf(str.charAt(i)) === -1) {
					str = str.substring(i);
					break;
				}
			}
		
			l = str.length;
			for (i = l - 1; i >= 0; i--) {
				if (whitespace.indexOf(str.charAt(i)) === -1) {
					str = str.substring(0, i + 1);
					break;
				}
			}
		
			return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
		};
		
		
		function addClass(value){
			var classNames, elem, setClass, c, cl;

			if (value && typeof value === "string") {
				classNames = value.split(rspace);
		
				elem = this;

				if (elem.nodeType === 1) {
					if (!elem.className && classNames.length === 1) {
						elem.className = value;

					} else {
						setClass = " " + elem.className + " ";

						for (c = 0, cl = classNames.length; c < cl; c++) {
							if (!~setClass.indexOf(" " + classNames[c] + " ")) {
								setClass += classNames[c] + " ";
							}
						}
						elem.className = trim(setClass);
					}
				}
			}
		};
		
		
		function removeClass(value){
			var classNames, elem, className, c, cl;

			if ((value && typeof value === "string") || value === undefined) {
				classNames = (value || "").split(rspace);
		
				elem = this;

				if (elem.nodeType === 1 && elem.className) {
					if (value) {
						className = (" " + elem.className + " ").replace(rclass, " ");
						for (c = 0, cl = classNames.length; c < cl; c++) {
							className = className.replace(" " + classNames[c] + " ", " ");
						}
						elem.className = trim(className);

					} else {
						elem.className = "";
					}
				}
			}
		};
		
		
		var el = document.getElementById("skinswitch-container");

		if(el.addEventListener){
			el.addEventListener("mouseover", function(event){
		    	removeClass.call(el, "skinswitch-item-hide-noncurrent");
		    }, false);
		    
		    el.addEventListener("mouseout", function(event){
		    	addClass.call(el, "skinswitch-item-hide-noncurrent");
		    }, false);
		}else{
			el.attachEvent("onmouseover", function(event){
		    	removeClass.call(el, "skinswitch-item-hide-noncurrent");
		    }, false);
		    
			el.attachEvent("onmouseout", function(event){
		    	addClass.call(el, "skinswitch-item-hide-noncurrent");
		    }, false);
		}
		
		
	};

	// onload
	if(typeof(jQuery) != 'undefined'){
		jQuery(ready);
	}else{
		window.addEvent('domready', ready);
	}
	
})();
</script>
{/literal}

{if $aSkinswitchTemplates}
	<div class="skinswitch-item-hide-noncurrent" id="skinswitch-container">
	{foreach item=sSkinswitchTemplateName from=$aSkinswitchTemplates}
		<a class="
			skinswitch-item
			{if $aSkinswitchCurrent==$sSkinswitchTemplateName}skinswitch-item-current{/if}
		" href="?{$aSkinswitchGetParam|escape:'url'}={$sSkinswitchTemplateName|escape:'url'}"
		>{$sSkinswitchTemplateName|escape:'html'}</a>
	{/foreach}
	</div>
{/if}