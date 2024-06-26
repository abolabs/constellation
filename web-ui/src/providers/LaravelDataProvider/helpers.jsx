import { stringify } from "qs";

const getQueryFromParams = (params) => {
  const { offsetPageNum } = params;
  const { page, perPage } = params.pagination;

  let currPage = page;
  if (offsetPageNum) {
    currPage += offsetPageNum;
  }

  // Create query with pagination params.
  const query = {
    page: currPage,
    perPage: perPage,
  };

  // Add all filter params to query.
  Object.keys(params.filter || {}).forEach((key) => {
    query[`filter[${key}]`] = params.filter[key];
  });

  // Add sort parameter
  if (params?.sort?.field) {
    const prefix = params.sort.order === "ASC" ? "" : "-";
    query.sort = `${prefix}${params.sort.field}`;
  }

  return query;
};

const getIds = (params, arrayFormat) => {
  const query = stringify(
    {
      "filter[id]": params.ids,
    },
    { arrayFormat: arrayFormat }
  );

  return query;
};

const convertFileToBase64 = (file) =>
  new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.onerror = reject;

    reader.readAsDataURL(file.rawFile);
  });

export { getQueryFromParams, getIds, convertFileToBase64 };
