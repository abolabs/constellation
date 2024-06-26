import axios from "axios";
import { stringify } from "qs";
import { getIds, getQueryFromParams } from "./helpers";
import AuthProvider from "../AuthProvider";

const defaultSettings = {
  headers: {
    "Access-Control-Allow-Origin": window.env?.CORS_ALLOWED_ORIGINS ?? "*",
    "Content-Type": "application/json",
  },
  initPage: 1,
  updateMethod: "PUT",
  arrayFormat: "brackets",
};

const laravelDataProvider = (
  apiURL,
  customSettings = {},
  tokenName = "token"
) => {
  let url = "";
  const settings = { ...customSettings, ...defaultSettings };
  const options = {
    headers: settings.headers,
  };

  const client = axios.create({
    baseURL: apiURL,
    ...settings,
  });

  client.interceptors.request.use(
    (config) => {
      const token = AuthProvider.getAccessToken();
      const newConfig = config;

      // When a 'token' is available set as Bearer token.
      if (token) {
        newConfig.headers.Authorization = `Bearer ${token}`;
      }
      return newConfig;
    },
    (err) => Promise.reject(err)
  );

  return {
    getPermissions: async () => {
      const res = await client.get("/user/permissions");
      return res.data;
    },
    resetPassword: async (params) => {
      const res = await client.post("/password-reset", params);
      return res.data;
    },
    passwordSendResetLink: async (params) => {
      const res = await client.post("/password-reset/send-link", params);
      return res.data;
    },
    updateProfile: async (params) => {
      const res = await client.put("/profile", params);
      if (res.data?.data?.meta?.jwt) {
        AuthProvider.setToken(res.data.data.meta.jwt);
      }
      return res.data;
    },
    getList: async (resource, params) => {
      const query = getQueryFromParams({ ...params, ...customSettings });

      url = `${apiURL}/${resource}?${stringify(query)}`;

      const res = await client({ url, ...options });

      return {
        data: res.data.data.map((item) => item),
        total: res.data.total,
      };
    },
    getOne: async (resource, params) => {
      url = `${apiURL}/${resource}/${params.id}`;

      const res = await client.get(url);
      return { data: { ...res.data?.data } };
    },
    getMany: async (resource, params) => {
      const query = getIds(params);

      url = `${apiURL}/${resource}?${query}`;

      const res = await client({ url, ...options });

      return {
        data: res.data.data.map((item) => item),
        total: res.data.total,
      };
    },
    getManyReference: async (resource, params) => {
      const query = getQueryFromParams({ ...params, ...customSettings });

      url = `${apiURL}/${resource}?${stringify(query)}`;

      const res = await client({ url, ...options });

      return {
        data: res.data.data.map((item) => item),
        total: res.data.total,
      };
    },
    create: async (resource, params) => {
      url = `${apiURL}/${resource}`;

      const res = await client.post(url, params.data);
      const { id, attributes } = res.data;

      return {
        data: {
          id,
          ...attributes,
        },
      };
    },
    update: async (resource, params) => {
      url = `${apiURL}/${resource}/${params.id}`;
      const attributes = params.data;
      delete attributes.id;
      const data = {
        ...attributes,
      };

      const res = await client.put(url, data);

      return {
        data: { ...res.data?.data },
      };
    },
    updateMany: (resource, params) => Promise,
    delete: async (resource, params) => {
      url = `${apiURL}/${resource}/${params.id}`;

      const res = await client.delete(url);

      return { data: { ...res.data } };
    },
    deleteMany: async (resource, params) => {
      const query = getIds(params, settings.arrayFormat);
      url = `${apiURL}/${resource}/${query}`;

      const res = await client.delete(url);

      return { data: { ...res.data } };
    },
    get: async (endpoint, params = {}) => {
      url = `${apiURL}/${endpoint}/?${stringify(params)}`;

      const res = await client.get(url);

      return res.data;
    },
    post: async (endpoint, data) => {
      url = `${apiURL}/${endpoint}`;

      const res = await client.post(url, data);

      return res.data;
    },
  };
};

export default laravelDataProvider;
