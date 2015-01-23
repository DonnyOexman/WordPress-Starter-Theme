/*!
 * WP Starter Theme Gruntfile
 * http://www.donnyoexman.com/
 * @author Donny Oexman <donnyoexman@gmail.com>
 */

'use strict';

module.exports = function( grunt ) {
  /**
   * Dynamically load npm tasks
   */
  require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

  /**
   * WP Starter Theme Grunt config
   */
  grunt.initConfig( {
    pkg: grunt.file.readJSON( 'package.json' ),

    /**
     * Set project info
     */
    project: {
      src: {
        dir: './src',
        sass: '<%= project.src.dir %>/scss',
        js: '<%= project.src.dir %>/js'
      },
      app: {
        dir: './',
        assets: './assets',
        js: '<%= project.app.assets %>/js',
        components: '<%= project.app.assets %>/components',
        images: '<%= project.app.assets %>/images',
        fonts: '<%= project.app.assets %>/fonts'
      },
      banner: {
        general: '/*!\n' +
          ' * <%= pkg.title %>\n' +
          ' * <%= pkg.url %>\n' +
          ' * @author <%= pkg.author.name %> <<%= pkg.author.email %>> (<%= pkg.author.url %>)\n' +
          ' * @version <%= pkg.version %>\n' +
          ' * Copyright <%= pkg.copyright %> <%= pkg.author.name %>.\n' +
          ' */\n',
        theme: '/*!\n' +
          ' * Theme Name: <%= pkg.title %>\n' +
          ' * Theme URI: <%= pkg.url %>\n' +
          ' * Author: <%= pkg.author.name %>\n' +
          ' * Author URI: <%= pkg.author.url %>\n' +
          ' * Version: <%= pkg.version %>\n' +
          ' * Text Domain: <%= pkg.name %>\n' +
          ' */\n'
      }
    },

    /*
     * Set notify hooks options
     */
    notify_hooks: {
      options: {
        enabled: true,
        max_jshint_notifications: 5,
        title: "<%= pkg.title %>"
      }
    },

    /**
     * JSHint
     * https://github.com/gruntjs/grunt-contrib-jshint
     */
    jshint: {
      options: {
        jshintrc: true
      },
      dist: {
        options: {
          "devel": false
        },
        files: {
          src: [ '<%= project.src.js %>/*.js' ]
        }
      },
      dev: {
        options: {
          "devel": true
        },
        files: {
          src: [ '<%= project.src.js %>/*.js' ]
        }
      }
    },

    /**
     * Uglify (minify) JavaScript files
     * https://github.com/gruntjs/grunt-contrib-uglify
     * Compresses and minifies all JavaScript files into one
     */
    uglify: {
      options: {
        banner: '<%= project.banner.general %>'
      },
      dist: {
        files: {
          '<%= project.app.js %>/app.min.js': '<%= project.src.js %>/*.js'
        }
      },
      modernizr: {
        src: '<%= project.app.components %>/modernizr/modernizr.js',
        dest: '<%= project.app.components %>/modernizr/modernizr.min.js'
      },
      jquery_placeholder: {
        src: '<%= project.app.components %>/jquery-placeholder/jquery.placeholder.js',
        dest: '<%= project.app.components %>/jquery-placeholder/jquery.placeholder.min.js'
      }
    },

    /* ImageMIN */
    imagemin: {
      options: {
        optimizationLevel: 7,
        cache: false
      },
      dist: {
        files: [ {
          cwd: '<%= project.app.images %>/',
          src: '{,*/}*.{png,jpg,jpeg,gif}',
          dest: '<%= project.app.images %>/',
          expand: true
        } ]
      }
    },

    /**
     * Compass
     * https://github.com/gruntjs/grunt-contrib-compass
     * Compiles all SASS/SCSS files by using Compass
     */
    compass: {
      options: {
        sassDir: '<%= project.src.sass %>',
        cssDir: '<%= project.app.dir %>',
        imagesDir: '<%= project.app.images %>',
        javascriptsDir: '<%= project.app.js %>',
        fontsDir: '<%= project.app.fonts %>',
        relativeAssets: true,
        require: [ 'rgbapng' ],
        importPath: [
          '<%= project.app.components %>/foundation/scss',
          '<%= project.app.components %>/fontawesome/scss'
        ],
        force: true
      },
      dist: {
        options: {
          environment: 'production'
        }
      },
      dev: {
        options: {
          environment: 'development'
        }
      }
    },

    copy: {
      font_awesome: {
        expand: true,
        flatten: true,
        src: [ '<%= project.app.components %>/fontawesome/fonts/*' ],
        dest: '<%= project.app.fonts %>/fontawesome'
      }
    },

    /**
     * Notify
     * https://github.com/gruntjs/grunt-contrib-notify
     * Notify when task is complete
     */
    notify: {
      js: {
        options: {
          title: 'JavaScript',
          message: 'Minified and checked successfully.'
        }
      },
      sass: {
        options: {
          title: 'SASS to CSS',
          message: 'Compiled and moved successfully.'
        }
      },
      dev: {
        options: {
          title: 'Development mode',
          message: 'Development tasks succesfully executed.'
        }
      },
      dist: {
        options: {
          title: 'Production mode',
          message: 'Production tasks succesfully executed.'
        }
      }
    },

    /**
     * Runs tasks against changed watched files
     * https://github.com/gruntjs/grunt-contrib-watch
     * Watching development files and run compile tasks
     */
    watch: {
      grunt: {
        files: [ 'Gruntfile.js' ],
        tasks: [ 'default' ]
      },
      js: {
        files: '<%= project.src.js %>/{,*/}*.js',
        tasks: [ 'jshint:dev', 'uglify:dist', 'notify:js' ]
      },
      sass: {
        files: '<%= project.src.sass %>/{,*/}*.{scss,sass}',
        tasks: [ 'compass:dev', 'notify:sass' ]
      }
    }
  } );

  /**
   * Default task (Development)
   * Run `grunt` on the command line
   */
  grunt.registerTask( 'default', [
    'copy',
    'jshint:dev',
    'uglify',
    'compass:dev',
    'watch',
    'notify:dev'
  ] );

  /**
   * Build task (Production)
   * Run `grunt build` on the command line
   */
  grunt.registerTask( 'build', [
    'copy',
    'jshint:dist',
    'uglify',
    'compass:dist',
    'imagemin',
    'notify:dist'
  ] );

  /**
   * Runs the task 'notify_hooks'. Required for custom notify options.
   */
  grunt.task.run( 'notify_hooks' );
}
