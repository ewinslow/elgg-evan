define(function(require) {
	var angular = require('angular');
	require('jquery/tinymce');
/**
 * Binds a TinyMCE widget to <textarea> elements.
 */
return function (elgg) {
  return {
    require: 'ngModel',
    link: function (scope, elm, attrs, ngModel) {
      var expression,
        options = {
          // Update model on button click
          onchange_callback: function (inst) {
            if (inst.isDirty()) {
              inst.save();
              ngModel.$setViewValue(elm.val());
              if (!scope.$$phase)
                scope.$apply();
            }
          },
          // Update model on keypress
          handle_event_callback: function (e) {
            if (this.isDirty()) {
              this.save();
              ngModel.$setViewValue(elm.val());
              if (!scope.$$phase)
                scope.$apply();
            }
            return true; // Continue handling
          },
          // Update model when calling setContent (such as from the source editor popup)
          setup: function (ed) {
            ed.onSetContent.add(function (ed, o) {
              if (ed.isDirty()) {
                ed.save();
                ngModel.$setViewValue(elm.val());
                if (!scope.$$phase)
                  scope.$apply();
              }
            });

            //show the number of words
            ed.onLoadContent.add(function(ed, o) {
              var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
              var text = elgg.echo('tinymce:word_count') + strip.split(' ').length + ' ';
              tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
            });

            ed.onKeyUp.add(function(ed, e) {
              var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
              var text = elgg.echo('tinymce:word_count') + strip.split(' ').length + ' ';
              tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
            });
          }
        };
      if (attrs.elggInputHtml) {
        expression = scope.$eval(attrs.elggInputHtml);
      } else {
        expression = {};
      }
      angular.extend(options, {
                theme : "advanced",
                language : elgg.config.language,
                plugins : "lists,spellchecker,paste",
                relative_urls : false,
                remove_script_host : false,
                document_base_url : elgg.config.wwwroot,
                theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,bullist,numlist,undo,redo,link,unlink,image,blockquote,code,pastetext,pasteword,more",
                theme_advanced_buttons2 : "",
                theme_advanced_buttons3 : "",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                theme_advanced_resizing : true,
                theme_advanced_path : true,
                width : "100%",
                extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
                content_css: elgg.config.wwwroot + 'mod/tinymce/css/elgg_tinymce.css'
        }, expression);
      setTimeout(function () {
        elm.tinymce(options);
      });
    }
  };
};
});
