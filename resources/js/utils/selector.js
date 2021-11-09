
export function make(select, url, id_key, text_key, default_query={}) {
  $(document).ready(() => {
    $(select).select2({
        ajax: {
            url: url,
            dataType: 'json',
            allowClear: true,
            data: function(params){
                console.log(default_query);
                if(typeof params.term == "undefined" || !params.term || /^\s*$/.test(params.term)){
                    return default_query;
                }

                let query = default_query;

                if(typeof text_key == "object"){
                    for(const single_label in text_key){
                        query[text_key[single_label]] = params.term;
                    }
                }else{
                    query[text_key] = params.term;
                }

                return query;
            },
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            processResults: function (response) {
                let data = []
                response.data.forEach((value) => {
                    let label  = "";
                    if(typeof text_key == "object"){
                        for(const single_label in text_key){
                            label +=  value[text_key[single_label]]+" ";
                        }
                    }else{
                        label = value[text_key];
                    }

                    data.push({
                        id: value[id_key],
                        text: "[#"+value[id_key]+"] "+label
                    })
                })
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data
                }
            }
        },
    });
  });
}
