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
import { defineConfig } from "vite";
import path from "path";
import react from "@vitejs/plugin-react";
import eslint from "vite-plugin-eslint";
import svgr from "vite-plugin-svgr";

export default defineConfig(() => {
  return {
    server: {
      host: "0.0.0.0",
      port: 3000,
    },
    resolve: {
      alias: {
        "@": path.resolve(__dirname, "src"),
        "@components": path.resolve(__dirname, "src/components"),
        "@contexts": path.resolve(__dirname, "src/contexts"),
        "@layouts": path.resolve(__dirname, "src/layouts"),
        "@pages": path.resolve(__dirname, "src/pages"),
        "@providers": path.resolve(__dirname, "src/providers"),
        "@themes": path.resolve(__dirname, "src/themes"),
        "@utils": path.resolve(__dirname, "src/utils"),
      },
    },
    build: {
      outDir: "build",
    },
    plugins: [
      react({
        jsxImportSource: "@emotion/react",
        babel: {
          plugins: ["@emotion/babel-plugin"],
        },
      }),
      eslint(),
      svgr({ svgrOptions: { icon: true } }),
    ],
  };
});
