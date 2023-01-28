import * as yup from 'yup';

const ServiceVersionDefaultSchema = yup.object()
    .shape({
        version: yup.string()
          .required('Please define a version')
          .typeError('Please define a version')
          .max(254),
    })
    .required();

export default ServiceVersionDefaultSchema;
