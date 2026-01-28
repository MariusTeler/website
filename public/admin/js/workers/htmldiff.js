onmessage = function(e) {
    importScripts('/public/site/js/vendor/htmldiff/htmldiff.min.js');

    let diff = e.data;

    for (id in diff) {
        for (key in diff[id]) {
            diff[id][key]['diff'] = htmldiff(diff[id][key]['old'], diff[id][key]['new']);
        }
    }

    postMessage(diff);
}