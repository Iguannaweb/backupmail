<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js"></script>
<script type="text/javascript">
			
	$( document ).ready(function() {
	
	    $(function () { 

		    $('#jstree_demo_div').jstree({
		        "core": {
		            "themes": {
		                "responsive": false
		            }            
		        },
		        "types": {
		            "default": {
		                "icon": "fa fa-folder text-warning fa-lg"
		            },
		            "file": {
		                "icon": "fa fa-file text-inverse fa-lg"
		            }
		        },
		        "state": { "key": "demo2" },
		        "plugins": ["types","state"]
		    });

			$("#jstree_demo_div").on('click', 'a.jstree-anchor', function (e, data) { 
				
				var href = $(this).attr("href");
			     document.location.href = href;
				
			});
			
			
			$('#jstree_tag_div').jstree({
		        "core": {
		            "themes": {
		                "responsive": false
		            }            
		        },
		        /* "types": {
		            "default": {
		                "icon": "fa fa-tag text-warning fa-lg"
		            },
		            "file": {
		                "icon": "fa fa-file text-inverse fa-lg"
		            }
		        }, */
		        "state": { "key": "demo2" },
		        "plugins": ["types","state"]
		    });
		    
		    $("#jstree_tag_div").on('click', 'a.jstree-anchor', function (e, data) { 
				
				var href = $(this).attr("href");
			     document.location.href = href;
				
			});
			
			$('#jstree_otros_div').jstree({
		        "core": {
		            "themes": {
		                "responsive": false
		            }            
		        },
		        "state": { "key": "demo2" },
		        "plugins": ["types","state"]
		    });
		    
		    $("#jstree_otros_div").on('click', 'a.jstree-anchor', function (e, data) { 
				
				var href = $(this).attr("href");
			     document.location.href = href;
				
			});
		    
		});
	
	});
		
		var handleEmailActionButtonStatus = function() {
			if ($('[data-checked=email-checkbox]:checked').length !== 0) {
				$('[data-email-action]').removeClass('hide');
			} else {
				$('[data-email-action]').addClass('hide');
			}
		};
		
		var handleEmailCheckboxChecked = function() {
			$(document).on('change', '[data-checked=email-checkbox]', function() {
				var targetLabel = $(this).closest('label');
				var targetEmailList = $(this).closest('li');
				if ($(this).prop('checked')) {
					$(targetLabel).addClass('active');
					$(targetEmailList).addClass('selected');
				} else {
					$(targetLabel).removeClass('active');
					$(targetEmailList).removeClass('selected');
				}
				handleEmailActionButtonStatus();
			});
		};
		
		var handleEmailAction = function() {
			$(document).on('click', '[data-email-action]', function() {
				var idmails = [];
		        $('[data-checked="email-checkbox"]:checked').each(function() {
		            idmails.push(this.name);
		        });
				var action=$(this).attr('data-email-action');
				console.log(idmails);
				console.log(action);
				
				if(action == "importante") {
					window.location.href = 'index.php?c=<?php echo $_GET["c"]; ?>&y=<?php echo $_GET["y"]; ?>&m=<?php echo $_GET["m"]; ?>&a=starb&mails=' + idmails.join('|') + '&page=<?php echo $_GET["page"]; ?>&ipp=<?php echo $_GET["ipp"]; ?>';
				
				} else if(action == "tarea") {
					window.location.href = 'index.php?c=<?php echo $_GET["c"]; ?>&y=<?php echo $_GET["y"]; ?>&m=<?php echo $_GET["m"]; ?>&a=tarea&mails=' + idmails.join('|') + '&page=<?php echo $_GET["page"]; ?>&ipp=<?php echo $_GET["ipp"]; ?>';

				} else if(action == "borrar") {
					window.location.href = 'index.php?c=<?php echo $_GET["c"]; ?>&y=<?php echo $_GET["y"]; ?>&m=<?php echo $_GET["m"]; ?>&a=borrar&mails=' + idmails.join('|') + '&page=<?php echo $_GET["page"]; ?>&ipp=<?php echo $_GET["ipp"]; ?>';

				} else if(action == "archivar") {
					window.location.href = 'index.php?c=<?php echo $_GET["c"]; ?>&y=<?php echo $_GET["y"]; ?>&m=<?php echo $_GET["m"]; ?>&a=archivar&mails=' + idmails.join('|') + '&page=<?php echo $_GET["page"]; ?>&ipp=<?php echo $_GET["ipp"]; ?>';

				} else if(action == "spam") {
					window.location.href = 'index.php?c=<?php echo $_GET["c"]; ?>&y=<?php echo $_GET["y"]; ?>&m=<?php echo $_GET["m"]; ?>&a=spam&mails=' + idmails.join('|') + '&page=<?php echo $_GET["page"]; ?>&ipp=<?php echo $_GET["ipp"]; ?>';

				}
				return false;

			});
		};
		
		var handleTagAction = function() {	
			$(document).on('click', '.tag-filter', function() {
				var targetEmailList = '[data-checked="email-checkbox"]:checked';
				
				
				var idmails = [];
		        $('[data-checked="email-checkbox"]:checked').each(function() {
		            idmails.push(this.name);
		        });
		        var tag=$(this).attr('data-idtag');
		        console.log('' + $(this).attr('data-idtag') + '');
		        console.log(idmails);
		        window.location.href = 'index.php?c=<?php echo $_GET["c"]; ?>&y=<?php echo $_GET["y"]; ?>&m=<?php echo $_GET["m"]; ?>&a=tag&t='+ tag + '&mails=' + idmails.join('|') + '&page=<?php echo $_GET["page"]; ?>&ipp=<?php echo $_GET["ipp"]; ?>';

			});
		};
		
		var handleunTagAction = function() {	
			$(document).on('click', '[data-actiontag]', function() {
				
		        var tagid=$(this).attr('data-actiontag');
		        var idmail=$(this).attr('data-idmail');
		        console.log('' + $(this).attr('data-actiontag') + '');
		        window.location.href = 'index.php?c=<?php echo $_GET["c"]; ?>&y=<?php echo $_GET["y"]; ?>&m=<?php echo $_GET["m"]; ?>&a=untag&t='+ tagid + '&mail=' + idmail + '&page=<?php echo $_GET["page"]; ?>&ipp=<?php echo $_GET["ipp"]; ?>';
				//return false;
			});
		};
		
		var handleEmailSelectAll = function () {
			"use strict";
			$(document).on('change', '[data-change=email-select-all]', function() {
				if (!$(this).is(':checked')) {
					$('.list-email .email-checkbox input[type="checkbox"]').prop('checked', false);
				} else {
					$('.list-email .email-checkbox input[type="checkbox"]').prop('checked', true);
				}
				$('.list-email .email-checkbox input[type="checkbox"]').trigger('change');
			});
		};
		
		var EmailInbox = function () {
			"use strict";
			return {
				//main function
				init: function () {
					handleEmailCheckboxChecked();
					handleEmailAction();
					handleunTagAction();
					handleTagAction();
					handleEmailSelectAll();
				}
			};
		}();
		
		$(document).ready(function() {
			EmailInbox.init();
		});

	
</script>