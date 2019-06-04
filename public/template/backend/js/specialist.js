$(document).ready(function () {
    $('.textarea').wysihtml5({
        "font-styles": false, //Font styling, e.g. h1, h2, etc
        "color": false, //Button to change color of font
        "emphasis": false, //Italics, bold, etc
        "textAlign": false, //Text align (left, right, center, justify)
        "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers
        "blockquote": false, //Button to insert quote
        "link": false, //Button to insert a link
        "table": false, //Button to insert a table
        "image": false, //Button to insert an image
        "video": false, //Button to insert YouTube video
        "html": false //Button which allows you to edit the generated HTML
    })
})