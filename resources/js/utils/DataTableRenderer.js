class DataTableRenderer {

    static boolean(column) {

        const column_name = column;

        return function (column_name) {
            let mode = '';

            if (this[column] || this[column] === "1" ) {
                mode = 'checked';
            }
            return '<label class="switch switch-label switch-success"> \
                        <input type="checkbox" class="switch-input" disabled '+mode+'> \
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span> \
                    </label>';
        };
    };
}

export default DataTableRenderer;
