import locale2b5e828d from '../..\\locales\\vi.json'
import locale9ec66352 from '../..\\locales\\en.json'

export const Constants = {
  COMPONENT_OPTIONS_KEY: "nuxtI18n",
  STRATEGIES: {"PREFIX":"prefix","PREFIX_EXCEPT_DEFAULT":"prefix_except_default","PREFIX_AND_DEFAULT":"prefix_and_default","NO_PREFIX":"no_prefix"},
  REDIRECT_ON_OPTIONS: {"ALL":"all","ROOT":"root","NO_PREFIX":"no prefix"},
}
export const nuxtOptions = {
  isUniversalMode: false,
  trailingSlash: undefined,
}
export const options = {
  vueI18n: {"fallbackLocale":"vi"},
  vueI18nLoader: false,
  locales: [{"code":"en","file":"en.json"},{"code":"vi","file":"vi.json"}],
  defaultLocale: "vi",
  defaultDirection: "ltr",
  routesNameSeparator: "___",
  defaultLocaleRouteNameSuffix: "default",
  sortRoutes: true,
  strategy: "prefix_except_default",
  lazy: false,
  langDir: "C:\\xampp\\htdocs\\min\\ATS\\ATS\\web\\locales\\",
  rootRedirect: null,
  detectBrowserLanguage: {"alwaysRedirect":false,"cookieCrossOrigin":false,"cookieDomain":null,"cookieKey":"i18n_redirected","cookieSecure":false,"fallbackLocale":"","redirectOn":"root","useCookie":true},
  differentDomains: false,
  baseUrl: "",
  vuex: {"moduleName":"i18n","syncRouteParams":true},
  parsePages: true,
  pages: {},
  skipSettingLocaleOnNavigate: false,
  onBeforeLanguageSwitch: () => {},
  onLanguageSwitched: () => null,
  normalizedLocales: [{"code":"en","file":"en.json"},{"code":"vi","file":"vi.json"}],
  localeCodes: ["en","vi"],
  additionalMessages: [],
}

export const localeMessages = {
  'vi.json': () => Promise.resolve(locale2b5e828d),
  'en.json': () => Promise.resolve(locale9ec66352),
}
