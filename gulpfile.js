// Gulp.js configuration

const
  // modules
  gulp = require('gulp'),

  // development mode?
  devBuild = (process.env.NODE_ENV !== 'production'),

  // folders
  src = 'Code/',
  build = 'Build/'
  ;