module.exports = function(grunt) {


  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      css: {
        files: ['assets/css/*.scss'],
        tasks: ['sass','postcss']
      },
      js: {
        files: ['assets/js/**.js','assets/js/**/**.js'],
        tasks: ['concat', 'uglify']
      },
      other: {
        files: ['*.html', 'templates/**'],
      },
      options: {
        // Start a live reload server on the default port 35729 
        livereload: true,
      },
    },

    concat: {
      dist: {
        src: ['assets/js/controllers/**.js','assets/js/directives/**.js','assets/js/services/**.js'],
        dest: 'dist/builtgular.js',
      },
    },

    uglify: {
      my_target: {
        files: {
          'dest/output.min.js': ['dist/builtgular.js']
        }
      }
    },

    sass: {
      dist: {
        files: {
          'assets/css/main.css': 'assets/css/main.scss',
        }
      }
    },
    postcss: {
      options: {
        processors: [
            require('pixrem')(), // add fallbacks for rem units
            require('autoprefixer')({browsers: 'last 5 versions'}), // add vendor prefixes
            require('cssnano')() // minify the result
            ]
          },
          dist: {
            src: 'assets/css/main.css'
          }
        }
      });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-postcss');

  // Default task(s).
  grunt.registerTask('default', ['watch']);

};