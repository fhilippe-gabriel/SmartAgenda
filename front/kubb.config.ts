// import { defineConfig } from "@kubb/core";
// import client from "@kubb/plugin-client";

// export default defineConfig({
//   root: "src",
//   input: {
//     path: "http://localhost:8000/api/documentation.json", // link do Swagger JSON
//   },
//   plugins: [
//     client({
//       output: "services", // pasta onde será gerado o cliente axios
//     }),
//   ],
// });
import type { KubbUserConfig } from "@kubb/core";

const config: KubbUserConfig = {
  input: {
    path: "http://localhost:8000/docs?api-docs.json", // link do Swagger JSON
  },
  output: {
    path: "./src/__generated__", // Onde ele vai gerar os arquivos
    clean: true,
  },
  plugins: [
    {
      name: "@kubb/plugin-client", // Gera as funções com Axios
      options: {
        client: "axios",
      },
    },
  ],
};

export default config;
