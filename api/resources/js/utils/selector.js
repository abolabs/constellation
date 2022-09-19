const { Index } = require("flexsearch");

export function make(select, url, id_key, text_key, default_query = {}, multiple = false) {

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    var searchParams = "";
    $(document).ready(() => {
        $(select).select2({
            width: '100%',
            multiple: multiple,
            allowClear: true,
            placeholder: "Select an option",
            ajax: {
                url: url,
                dataType: 'json',
                allowClear: true,
                data: function (params) {
                    if (typeof params.term == "undefined" || !params.term || /^\s*$/.test(params.term)) {
                        return default_query;
                    }

                    let query = default_query;

                    if (typeof text_key == "object") {
                        for (const single_label in text_key) {
                            query[text_key[single_label]] = params.term;
                        }
                    } else {
                        query[text_key] = params.term;
                    }
                    searchParams = params.term;
                    return query;
                },
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function (response) {
                    let data = []
                    let labels = []
                    let responseData = []
                    let noSearch = false
                    if(typeof searchParams == "undefined" || !searchParams || /^\s*$/.test(searchParams)){
                        noSearch = true
                    }

                    const index = new Index({
                        preset: "performance",
                        resolution: 5,
                        tokenize: "full",
                    });

                    response.data.forEach((value) => {
                        labels[value.id] = ""
                        if (typeof text_key == "object") {
                            for (const single_label in text_key) {
                                labels[value.id] += value[text_key[single_label]];
                                if (single_label < text_key.length - 1) {
                                    labels[value.id] += " - ";
                                }
                            }
                        } else {
                            labels[value.id] = value[text_key];
                        }
                        if (noSearch) {
                            // display all if no search
                            data.push({
                                id: value.id,
                                text: "[#" + value.id + "] " + labels[value.id]
                            })
                        }else{
                            responseData[value.id] = value
                            index.add(value.id, JSON.stringify(value));
                        }
                    })
                    // Result filter
                    if(noSearch === false){
                        index.search(searchParams).forEach((matchingEntry) => {
                            const resultValue = responseData[matchingEntry]
                            data.push({
                                id: resultValue.id,
                                text: "[#" + resultValue.id + "] " + labels[resultValue.id]
                            })

                        })
                    }
                    searchParams = ""

                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    }
                }
            },
        });
    });
}
