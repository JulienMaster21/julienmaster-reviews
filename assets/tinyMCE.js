/**
 * Initiate the TinyMCE editor for all textarea inputs
 *
 * See https://www.tiny.cloud/docs/plugins for more information about plugins
 * Current Plugins:
 * autolink: Automatically convert urls into hyperlinks.
 * autoresize: Automatically adjust the size of the editor.
 * autosave: Automatically make backups of the typed content.
 * charmap: Add a menu to insert special characters.
 * code: Show the source code of the currently typed content in HTML.
 * codesample: Add a menu to insert syntax highlighted code samples.
 * directionality: Add ltr and rtl text direction options.
 * emoticons: Add a menu to insert emoticons.
 * help: Add a help menu to the editor.
 * hr: Add a button to insert a horizontal line.
 * image: Add a menu to insert images.
 * imagetools: Add a content menu when an image is selected.
 * link: Add a menu to insert hyperlinks.
 * lists: Add a menu to insert ordered and unordered lists.
 * advlist: Extend lists to include styling options.
 * media: Add a menu to insert video and audio.
 * nonbreaking: Add a button to insert a non-breaking space
 * paste: Add a button to paste content from Microsoft Word.
 * preview: Add a preview button.
 * quickbars: Add context menus to the editor.
 * searchreplace: Add the search and replace options.
 * table: Add a menu to insert a table.
 * toc: Adds a menu to insert a table of contents.
 * wordcount: Add a word count to the editor.
 */
tinymce.init({
    selector: 'textarea',
    plugins: 'autolink autoresize autosave charmap code codesample directionality emoticons ' +
             'help hr image imagetools link lists advlist media nonbreaking paste preview quickbars ' +
             'save searchreplace table toc wordcount',
    toolbar: 'save restoredraft paste searchreplace bullist numlist table toc emoticons hr link ' +
             'image media nonbreaking charmap codesample ltr rtl preview code wordcount help',
    toolbar_mode: 'floating'
});