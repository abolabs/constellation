
export function make(select, url, id_key, text_key) {
  $(document).ready(() => { 
    $(select).select2({
        ajax: {
            url: url,
            dataType: 'json',
            allowClear: true,
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            processResults: function (response) {
                let data = []
                response.data.forEach((value) => {
                    data.push({
                        id: value[id_key],
                        text: "["+value[id_key]+"] "+value[text_key]
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