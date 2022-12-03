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
    localStorage.setItem("auth", response.data.access_token);

    return Promise.resolve(response.data.access_token);
  },
  logout: () => {
    localStorage.removeItem("auth");
    return Promise.resolve();
  },
  checkAuth: () => {
    return localStorage.getItem("auth") ? Promise.resolve() : Promise.reject();
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
  getIdentity: () => {
    try {
      const token = localStorage.getItem("auth");
      const jwt = jwt_decode(token);
      const identity = { id: "my-profile", fullName: jwt.name, email: jwt.email };
      return Promise.resolve(identity);
    } catch (e) {
      console.error("getIdentity", e);
    }

    return Promise.resolve({
      id: "my-profile",
      fullName: "Unknown",
      email: ""
    });
  },
  getPermissions: () => Promise.resolve(""),
};

export default AuthProvider;
