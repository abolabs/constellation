import * as yup from 'yup';

const HostingDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define a hosting name')
          .typeError('Please define a hosting name')
          .max(254),
        localisation: yup.string()
          .nullable()
          .max(254),
        hosting_type_id: yup.number()
          .required('Please select a hosting type')
          .typeError('Please select a hosting type')
    })
    .required();

export default HostingDefaultSchema;
