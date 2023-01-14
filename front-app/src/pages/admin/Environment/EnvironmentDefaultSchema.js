import * as yup from 'yup';

const EnvironmentDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define a service name')
          .typeError('Please define a service name')
          .max(254),
    })
    .required();

export default EnvironmentDefaultSchema;
