import * as yup from 'yup';

const ServiceDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define a service name')
          .typeError('Please define a service name')
          .max(254),
        localisation: yup.string()
          .required('Please define a location')
          .typeError('Please define a location')
          .nullable()
          .max(254),
        hosting_type_id: yup.number()
          .required('Please select a hosting type')
          .typeError('Please select a hosting type')
    })
    .required();

export default ServiceDefaultSchema;
