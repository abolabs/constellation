import axios from "axios";
import jwt_decode from "jwt-decode";

const AuthProvider = {
  login: async ({ email, password }) => {
    const response = await axios
      .post(
        `${process.env.REACT_APP_ISSUER}/oauth/token`,
        {
          grant_type: "password",
          username: email,
          password: password,
          scope: "*",
          client_id: process.env.REACT_APP_CLIENT_ID,
          client_secret: process.env.REACT_APP_CLIENT_SECRET,
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
    console.log("checkAuth", localStorage.getItem("auth"));
    return localStorage.getItem("auth") ? Promise.resolve() : Promise.reject();
  },
  checkError: (error) => {
    const status = error.status;
    console.log("checkError", status);
    if (status === 401 || status === 403) {
      localStorage.removeItem("auth");
      return Promise.reject();
    }
    // other error code (404, 500, etc): no need to log out
    return Promise.resolve();
  },
  getIdentity: () => {
    try {
      const token = localStorage.getItem("auth");
      console.log("token", jwt_decode(token));
      const jwt = jwt_decode(token);
      console.log("getIdentity ", jwt);
      const identity = { id: "my-profile", fullName: jwt.name };
      return Promise.resolve(identity);
    } catch (e) {
      console.log(" ball in the pâté ", e);
    }

    return Promise.resolve({
      id: "my-profile",
      fullName: "Unknown",
    });
  },
  getPermissions: () => Promise.resolve(""),
};

export default AuthProvider;
