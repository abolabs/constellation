import { stringify } from 'qs';

const getQueryFromParams = params => {
  const { offsetPageNum } = params
  const { page, perPage } = params.pagination;

  let currPage = page;
  if (offsetPageNum !== null || offsetPageNum !== undefined) {
    currPage += offsetPageNum
  }

  // Create query with pagination params.
  const query = {
    'page': currPage,
    'perPage': perPage,
  };

  // Add all filter params to query.
  Object.keys(params.filter || {}).forEach((key) => {
    query[`filter[${key}]`] = params.filter[key];
  });

  // Add sort parameter
  if (params.sort && params.sort.field) {
    const prefix = params.sort.order === 'ASC' ? '' : '-';
    query.sort = `${prefix}${params.sort.field}`;
  }

  return query;
}

const getIds = (params, arrayFormat) => {
  const query = stringify({
    'filter[id]': params.ids,
  }, { arrayFormat: arrayFormat });

  return query;
}

export {
  getQueryFromParams,
  getIds
};
