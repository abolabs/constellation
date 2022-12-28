import * as yup from 'yup';

const ServiceDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define a service name')
          .typeError('Please define a service name')
          .max(254),
        git_repo: yup.string()
          .required('Please define a git url')
          .typeError('Please define a git url')
          .url()
          .nullable()
          .max(254),
        team_id: yup.number()
          .required('Please select a team')
          .typeError('Please select a team')
    })
    .required();

export default ServiceDefaultSchema;
