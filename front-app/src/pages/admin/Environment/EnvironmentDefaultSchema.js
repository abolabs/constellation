import * as yup from 'yup';

const EnvironmentDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define an environment name')
          .typeError('Please define an environment name')
          .max(254),
    })
    .required();

export default EnvironmentDefaultSchema;
