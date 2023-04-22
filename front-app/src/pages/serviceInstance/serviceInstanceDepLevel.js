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

const serviceInstanceDepLevel = {
  1: {
    color: "primary",
    label: "minor",
    value: 1,
    description: "En cas d'indisponibilité : impact sur fonctionnalité(s) mineure(s) ou majeure(s) avec solution de contournement."
  },
  2: {
    color: "warning",
    label: "major",
    value: 2,
    description: "En cas d'indisponibilité : impact sur fonctionnalité(s) majeure(s) sans solution de contournement mais sans indisponibilité générale."
  },
  3: {
    color: "error",
    label: "critic",
    value: 3,
    description: "En cas d'indisponibilité : impact de fonctionnalité(s) majeure(s) sans solution de contournement entrainant une indisponibilité générale de l'application."
  }
};

export { serviceInstanceDepLevel };
