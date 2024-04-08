#!/usr/bin/env zx

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
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


import gradient from 'gradient-string';
import prompts from 'prompts';
import { $ } from 'zx/core';

function log(...message) {
  const firstMessage = message?.[0];
  const otherMessages = message.slice(1);

  console.log(firstMessage);
  if (otherMessages.length > 0) {
    console.group();
  }
  otherMessages.forEach((otherMessage) => {
    console.log(otherMessage);
  });
  if (otherMessages.length > 0) {
    console.groupEnd();
  }
}

function debug(message) {
  if ($.verbose) {
    console.log(message);
  }
}

function info(...message) {
  if ($.verbose) {
    const infoGradient = gradient(['#084C61', '#177E89', '#084C61']);
    printGradient(infoGradient, '[Info]', ...message);
  }
}

function warn(...message) {
  const infoGradient = gradient(['#d08025', '#e67b00']);
  printGradient(infoGradient, '[Warn]', ...message);
}

function error(...message) {
  const errorGradient = gradient(['#ff0025', 'purple']);
  printGradient(errorGradient, '[Error]', ...message);
}

function confirm(...message) {
  const errorGradient = gradient(['#38c172', '#128e46']);
  printGradient(errorGradient, '[OK]', ...message);
}

function printError(promise) {
  error(`[Exit=${promise.exitCode}] ${promise?.stderr}`, `signal: ${promise.signal}`);
  debug(promise.stdout);
}

function printGradient(gradient, prefix, ...message) {
  const coloredPrefix = gradient(prefix);

  const firstMessage = message?.[0];
  const otherMessages = message.slice(1);

  console.log(`${coloredPrefix}`, firstMessage);

  if (otherMessages.length > 0) {
    console.group();
  }
  otherMessages.forEach((otherMessage) => {
    console.log(otherMessage);
  });
  if (otherMessages.length > 0) {
    console.groupEnd();
  }
}

export default { confirm, error, log, info, warn, printError, prompts };
