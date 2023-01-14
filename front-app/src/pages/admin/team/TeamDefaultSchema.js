import * as yup from 'yup';

const TeamDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define a service name')
          .typeError('Please define a service name')
          .max(254),
        manager: yup.string()
          .required('Please define a manager')
          .typeError('Please define a manager')
          .max(254),
    })
    .required();

export default TeamDefaultSchema;
