class DataTableRenderer {

    static boolean(column) {

        const column_name = column;

        return function (column_name) {
            let mode = ''

            if (this[column] || this[column] === "1" ) {
                mode = 'checked'
            }
            return '<label class="switch switch-label switch-success">' +
                        '<input type="checkbox" class="switch-input" disabled '+mode+'> '+
                        '<span class="switch-slider" data-checked="On" data-unchecked="Off"></span> '+
                    '</label>'
        };
    };

    static level(column) {

        const column_name = column;

        return function (column_name) {
            let bg = ''

            switch(this[column]) {
                case 1:
                    bg = 'success'
                    break;
                case 2:
                    bg = 'warning'
                    break;
                case 3:
                    bg = 'danger'
                    break;
                default:
                    console.log('invalid level - ',this[column]);
                    return this[column]
            }
            let label = window.lang.get('service_instance_dependencies.level.'+this[column]);

            return '<span class="badge badge-'+bg+'"> '+label+'</span>'
        };
    };
}

export default DataTableRenderer;
