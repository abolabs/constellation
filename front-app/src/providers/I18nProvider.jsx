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
import polyglotI18nProvider from "ra-i18n-polyglot";

import frenchMessages from "@i18n/frenchMessages";
import englishMessages from "@i18n/englishMessages";

const translations = {
  fr: frenchMessages,
  en: englishMessages,
};

const i18nProvider = polyglotI18nProvider(
  (locale) => translations[locale],
  "en", // default locale
  [
    { locale: "en", name: "English" },
    { locale: "fr", name: "Français" },
  ]
);

export default i18nProvider;
