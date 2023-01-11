window.onload = function() {
    const inputName = document.querySelector("input[id='News_name']");
    inputName.addEventListener('change', updateFromName, false);

    const inputSlug = document.querySelector("input[id='News_slug']");
    inputSlug.addEventListener('change', updateFromSlug, false);
}

function updateFromName(e) {

    let val = e.target.value.toLowerCase();
    val = val.trim();
    let arr_search = [' ', 'ä', 'ö', 'ü', '.' ]
    let arr_replace = ['-', 'ae', 'oe', 'ue', '']
    val = val.replaceArray(arr_search, arr_replace);
    document.getElementById("News_slug").value = val.trim();
}

function updateFromSlug(e) {

    let val = e.target.value.toLowerCase();
    val = val.trim();
    let arr_search = [' ', 'ä', 'ö', 'ü', '.' ]
    let arr_replace = ['-', 'ae', 'oe', 'ue', '']
    val = val.replaceArray(arr_search, arr_replace);
    document.getElementById("News_slug").value = val.trim();
}

String.prototype.replaceArray = function(find, replace) {
    var replaceString = this;
    for (var i = 0; i < find.length; i++) {
        replaceString = replaceString.replaceAll(find[i], replace[i]);
    }
    return replaceString;
};