// Copyright (C) 2023 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

import axios from "axios";
import jwt_decode from "jwt-decode";

const AuthProvider = {
  login: async ({ email, password }) => {
    const response = await axios
      .post(
        `${window.env.REACT_APP_ISSUER}/oauth/token`,
        {
          grant_type: "password",
          username: email,
          password: password,
          scope: "*",
          client_id: window.env.REACT_APP_CLIENT_ID,
          client_secret: window.env.REACT_APP_CLIENT_SECRET,
        },
        {
          headers: {
            "Access-Control-Allow-Origin": "*",
            "Content-Type": "application/json",
          },
        }
      )
      .catch((error) => {
        throw new Error(error);
      });

    if (response.status < 200 || response.status >= 300) {
      throw new Error(response.statusText);
    }
    AuthProvider.setToken(response?.data);

    return Promise.resolve(response.data);
  },
  logout: () => {
    localStorage.removeItem("auth");
    return Promise.resolve();
  },
  checkAuth: () => {
    return AuthProvider.getToken() ? Promise.resolve() : Promise.reject();
  },
  checkError: (error) => {
    const status = error.status;
    if (status === 401 || status === 403) {
      console.error("unauthenticated");
      localStorage.removeItem("auth");
      return Promise.reject();
    }
    // other error code (404, 500, etc): no need to log out
    return Promise.resolve();
  },
  getAccessToken: () => {
    const token = AuthProvider.getToken();
    return JSON.parse(token)?.access_token;
  },
  getToken: () => {
    return localStorage.getItem("auth");
  },
  setToken: (data) => {
    localStorage.setItem("auth", JSON.stringify(data));
    return true;
  },
  getIdentity: () => {
    try {
      const token = AuthProvider.getToken();
      const jwt = jwt_decode(JSON.parse(token)?.access_token);
      const identity = {
        id: "my-profile",
        fullName: jwt.name,
        email: jwt.email,
      };
      return Promise.resolve(identity);
    } catch (e) {
      console.error("getIdentity", e);
    }

    return Promise.resolve({
      id: "my-profile",
      fullName: "Unknown",
      email: "",
    });
  },
  getPermissions: () => Promise.resolve(""),
};

export default AuthProvider;
