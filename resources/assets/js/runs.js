//require("./bootstrap");
var Bloodhound = require("typeahead.js-browserify").Bloodhound
var jQuery = require("jquery");
var typeahead = require("typeahead.js/dist/typeahead.jquery");
//typeahead.loadjQueryPlugin();
// var t = jQuery.fn.typeahead.noConflict();
// jQuery.fn._typeahead = t;
console.log(typeahead);
var engines = {};
// passing in `null` for the `options` arguments will result in the default
// options being used
var createEngine = (item_name) => {
    let i = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // url points to a json file that contains an array of country names, see
        // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
        remote: {
            url: window.Laravel.basePath + "/api/search/"+item_name+"?name=%QUERY",
            wildcard: '%QUERY'
        }
    });
    engines[item_name] = i
    return i;
}
document.querySelectorAll(".btn.searchable").forEach((el)=>{
    el.addEventListener("click",()=>{
        const searchable = el.dataset.searchable;
        var container = document.createElement("div");
        let input = document.createElement("input");
        let engine = searchable in engines ? engines[searchable] : createEngine(searchable) //TODO add something allowing multiple parameters to be searched, (not just name)
        input.classList.add("typeahead");
        input.setAttribute("type","text");
        input.setAttribute("placeholder","Search for a car types");

        var deleteAndSubmit = function() {
            console.log("replacing input "+container+" with "+el)
            //submit form in the future
            let val = {}
            val[searchable] = input.value;
            console.log(val)
            // window.api.post("/runs/{runId}/{searchable}, {})
            container.replaceWith(el);
        }
        input.addEventListener("keydown",function(e){
            if (e.keyCode == 13)
                deleteAndSubmit()
        })
        input.addEventListener("blur",deleteAndSubmit)
        $(input).typeahead({
            hint: true,
            highlight: true,
            limit: 5,
            minLength: 1
        }, {
            displayKey:"name",
            source: engine
        });

        container.appendChild(input);
        el.replaceWith(container);

    })
});
