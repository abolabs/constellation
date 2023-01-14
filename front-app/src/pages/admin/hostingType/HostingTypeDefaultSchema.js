import * as yup from 'yup';

const HostingTypeDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define a hosting type name')
          .typeError('Please define a hosting type name')
          .max(254),
        description: yup.string()
          .required('Please define a description')
          .typeError('Please define a description')
          .max(254),
    })
    .required();

export default HostingTypeDefaultSchema;
