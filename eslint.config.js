import globals from "globals";
import js from "@eslint/js";
import vue from "eslint-plugin-vue";
import vitest from "eslint-plugin-vitest";
import prettier from "eslint-config-prettier";

export default [
    js.configs.recommended,
    ...vue.configs["flat/recommended"],
    {
        name: "ignores",
        ignores: ["node_modules/", "vendor/"],
    },
    {
        name: "base",
        files: ["**/*.{js,vue}"],
        languageOptions: {
            globals: {
                ...globals.browser,
            },
        },
    },
    {
        name: "custom rules",
        rules: {
            "no-unused-vars": "warn",
        },
    },
    {
        name: "tests",
        files: ["**/*.test.{js,vue}"],
        languageOptions: {
            globals: {
                ...vitest.environments.env.globals,
            },
        },
        plugins: { vitest },
        rules: { ...vitest.configs.recommended.rules },
    },
    {
        name: "prettier",
        rules: { ...prettier.rules },
    },
];
