/* Garlicjs dist/garlic.min.js build version 1.2.3 http://garlicjs.org */
!function(b){var h=function(){this.defined="undefined"!==typeof localStorage};h.prototype={constructor:h,get:function(a,b){return localStorage.getItem(a)?localStorage.getItem(a):"undefined"!==typeof b?b:null},has:function(a){return localStorage.getItem(a)?!0:!1},set:function(a,b,d){"string"===typeof b&&(""===b?this.destroy(a):localStorage.setItem(a,b));return"function"===typeof d?d():!0},destroy:function(a,b){localStorage.removeItem(a);return"function"===typeof b?b():!0},clean:function(a){for(var b=
localStorage.length-1;0<=b;b--)"undefined"===typeof Array.indexOf&&-1!==localStorage.key(b).indexOf("garlic:")&&localStorage.removeItem(localStorage.key(b));return"function"===typeof a?a():!0},clear:function(a){localStorage.clear();return"function"===typeof a?a():!0}};var j=function(a,b,d){this.init("garlic",a,b,d)};j.prototype={constructor:j,init:function(a,c,d,f){this.type=a;this.$element=b(c);this.options=this.getOptions(f);this.storage=d;this.path=this.options.getPath(this.$element)||this.getPath();
this.parentForm=this.$element.closest("form");this.$element.addClass("garlic-auto-save");this.expiresFlag=!this.options.expires?!1:(this.$element.data("expires")?this.path:this.getPath(this.parentForm))+"_flag";this.$element.on(this.options.events.join("."+this.type+" "),!1,b.proxy(this.persist,this));if(this.options.destroy)b(this.parentForm).on("submit reset",!1,b.proxy(this.destroy,this));this.retrieve()},getOptions:function(a){return b.extend({},b.fn[this.type].defaults,a,this.$element.data())},
persist:function(){this.val!==this.getVal()&&(this.val=this.getVal(),this.options.expires&&this.storage.set(this.expiresFlag,((new Date).getTime()+1E3*this.options.expires).toString()),this.storage.set(this.path,this.getVal()),this.options.onPersist(this.$element,this.getVal()))},getVal:function(){return!this.$element.is("input[type=checkbox]")?this.$element.val():this.$element.prop("checked")?"checked":"unchecked"},retrieve:function(){if(this.storage.has(this.path)){if(this.options.expires){var a=
(new Date).getTime();if(this.storage.get(this.expiresFlag)<a.toString()){this.storage.destroy(this.path);return}this.$element.attr("expires-in",Math.floor((parseInt(this.storage.get(this.expiresFlag))-a)/1E3))}a=this.storage.get(this.path);if(this.options.conflictManager.enabled&&this.detectConflict())return this.conflictManager();if(this.$element.is("input[type=radio], input[type=checkbox]")){if("checked"===a||this.$element.val()===a)return this.$element.attr("checked",!0);"unchecked"===a&&this.$element.attr("checked",
!1)}else this.$element.val(a),this.options.onRetrieve(this.$element,a)}},detectConflict:function(){var a=this;if(this.$element.is("input[type=checkbox], input[type=radio]"))return!1;if(this.$element.val()&&this.storage.get(this.path)!==this.$element.val()){if(this.$element.is("select")){var c=!1;this.$element.find("option").each(function(){0!==b(this).index()&&(b(this).attr("selected")&&b(this).val()!==a.storage.get(this.path))&&(c=!0)});return c}return!0}return!1},conflictManager:function(){if("function"===
typeof this.options.conflictManager.onConflictDetected&&!this.options.conflictManager.onConflictDetected(this.$element,this.storage.get(this.path)))return!1;this.options.conflictManager.garlicPriority?(this.$element.data("swap-data",this.$element.val()),this.$element.data("swap-state","garlic"),this.$element.val(this.storage.get(this.path))):(this.$element.data("swap-data",this.storage.get(this.path)),this.$element.data("swap-state","default"));this.swapHandler();this.$element.addClass("garlic-conflict-detected");
this.$element.closest("input[type=submit]").attr("disabled",!0)},swapHandler:function(){var a=b(this.options.conflictManager.template);this.$element.after(a.text(this.options.conflictManager.message));a.on("click",!1,b.proxy(this.swap,this))},swap:function(){var a=this.$element.data("swap-data");this.$element.data("swap-state","garlic"===this.$element.data("swap-state")?"default":"garlic");this.$element.data("swap-data",this.$element.val());b(this.$element).val(a)},destroy:function(){this.storage.destroy(this.path)},
remove:function(){this.remove();this.$element.is("input[type=radio], input[type=checkbox]")?b(this.$element).prop("checked",!1):this.$element.val("")},getPath:function(a){"undefined"===typeof a&&(a=this.$element);if(this.options.getPath(a))return this.options.getPath(a);if(1!=a.length)return!1;for(var c="",d=a.is("input[type=checkbox]"),f=a;f.length;){a=f[0];var e=a.nodeName;if(!e)break;var e=e.toLowerCase(),f=f.parent(),g=f.children(e);if(b(a).is("form, input, select, textarea")||d)if(e+=b(a).attr("name")?
"."+b(a).attr("name"):"",1<g.length&&!b(a).is("input[type=radio]")&&(e+=":eq("+g.index(a)+")"),c=e+(c?">"+c:""),"form"==a.nodeName.toLowerCase())break}return"garlic:"+document.domain+(this.options.domain?"*":window.location.pathname)+">"+c},getStorage:function(){return this.storage}};b.fn.garlic=function(a,c){function d(c){var d=b(c),g=d.data("garlic"),h=b.extend({},f,d.data());if(("undefined"===typeof h.storage||h.storage)&&"password"!==b(c).attr("type"))if(g||d.data("garlic",g=new j(c,e,h)),"string"===
typeof a&&"function"===typeof g[a])return g[a]()}var f=b.extend(!0,{},b.fn.garlic.defaults,a,this.data()),e=new h,g=!1;if(!e.defined)return!1;this.each(function(){b(this).is("form")?b(this).find(f.inputs).each(function(){g=d(b(this))}):b(this).is(f.inputs)&&(g=d(b(this)))});return"function"===typeof c?c():g};b.fn.garlic.Constructor=j;b.fn.garlic.defaults={destroy:!0,inputs:"input, textarea, select",events:"DOMAttrModified textInput input change click keypress paste focus".split(" "),domain:!1,expires:!1,
conflictManager:{enabled:!1,garlicPriority:!0,template:'<span class="garlic-swap"></span>',message:"This is your saved data. Click here to see default one",onConflictDetected:function(){return!0}},getPath:function(){},onRetrieve:function(){},onPersist:function(){}};b(window).on("load",function(){b('[data-persist="garlic"]').each(function(){b(this).garlic()})})}(window.jQuery||window.Zepto);

/*!
* Style Gravity Forms with bootstrap
*
* Credit to Guy at Git - https://github.com/danmasta/bootstrap-gravity-forms
*
*Drop in function to add Bootstrap 3 support to Gravity Forms inputs
*
*/


(function($){
    var gform = $(document).find('.gform_wrapper').attr('class');
    if(typeof gform !== 'undefined' && gform !== 'false'){
        $(document).on('gform_post_render',function(){
            var form = $('.gform_wrapper');
            var required = $('.gfield_contains_required');
            var controlGroup = $('.gfield').not('.gsection,.gfield_html');
            //fields for pregression
            var fields = form.find('input, textarea, select, .gfield_radio, .gfield_checkbox').not('input[type="checkbox"], input[type="radio"], input[type="submit"], input[type="button"], input[type="hidden"]');

            required.each(function(){
                $(this).find('input, textarea, select').not('input[type="checkbox"], input[type="radio"]').attr('required', 'true');
            });

            //$(this).find('div').addClass( 'wow bounceInUp');

            //form.find('form').addClass('row').find('.gform_body').addClass('col-md-6');


			/* fields.each(function(){
			 		//$(this).attr('data-progression', '');
			 		//description = $(this).parent().prev('label').text();
			 		//console.log(description);
			        //$(this).attr('data-progression', '').attr('data-helper', description);
			 });*/



            $('.gform_fields').each(function(){
                $(this).addClass('row');
            });
            controlGroup.each(function(){
                $(this).addClass('form-group').find('input, textarea, select').not('input[type="checkbox"], input[type="radio"],.gform_button_select_files').after('<span class="help-block"></span>').addClass('form-control');
            });
            form.find("input[type='submit'], input[type='button']").addClass('btn btn-primary').end().find('.gfield_error').removeClass('gfield_error').addClass('has-error');

            //form.find(".ginput_complex").addClass('form-inline').find('.ginput_left,.ginput_right').addClass('form-group');
            form.find(".ginput_complex").addClass('row').find('.ginput_left,.ginput_right').addClass('col-xs-12 col-sm-6').parent().find('.ginput_full').addClass('col-xs-12');



            $('.gfield_checkbox, .gfield_radio').find('input[type="checkbox"], input[type="radio"]').each(function(){
                var sib = $(this).siblings('label');
                //$(this).prependTo(sib); //Removed this to not move the label outside of checkbox.
            }).end().each(function(){
                $(this).after('<span class="help-block"></span>');
                if($(this).is('.gfield_checkbox')){
                    $(this).addClass('checkbox');
                } else {
                    $(this).addClass('radio');
                }
            });
            $('.validation_message').each(function(){
                var sib = $(this).prev().find('.help-block');
                $(this).appendTo(sib);
            });
            $('.validation_error').addClass('alert alert-danger');
            //$('.gf_progressbar').addClass('progress progress-striped active').children('.gf_progressbar_percentage').addClass('progress-bar progress-bar-success');
        });
    } else {
        console.log('no forms were found');
        return false;
    }






})(jQuery);








jQuery(document).bind('gform_page_loaded', function(event, form_id, current_page){


  //Add garlic
jQuery( 'form' ).garlic();

});



