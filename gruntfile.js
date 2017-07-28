module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        // banner: '/*! <%= pkg.name %> <%= grunt.template.today() %> */\n'
      },
      dist: {
        files: {
          'site.js': ['js/site.js']
        }
      }
    },
    jshint: {
      files: [ 'gruntfile.js', 'js/*.js' ],
      options: {
        asi: true,
        smarttabs: true,
        laxcomma: true,
        lastsemic: true,
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    notify: {
      watch: {
        options: {
          title: 'Dun\' Grunted',
          message: 'All is good'
        }
      }
    },
    less: {
        production: {
	        options: {
		        cleancss: true,
            banner: "//testing one two three"
			},
			files: {
				'style.css': ['less/style.less', 'less/bootstrap/bootstrap.less']
			}
		},
		development: {
			files: {
				'style.dev.css': 'less/style.less'
			}
		}
    },
    banner: '/* \n' +
          ' Theme Name:   Foul Weather Films \n' +
          ' Theme URI:    http://foulweatherfilms.com/ \n' +
          ' Description:  Backend theme for wp to do the handling and rest api delivery to front-end react interface \n' +
          ' Author:       Nick Winkelbauer \n' +
          ' Author URI:   \n' +
          ' Template:     twentyseventeen \n' +
          ' Version:      1.0.0 \n' +
          ' Tags:         react, rest, backend, portfolio \n' +
          '*/ \n',
    usebanner: {
      dist: {
        options: {
          position: 'top',
          banner: '<%= banner %>'
        },
        files: {
          src: [ 'style.css' , 'style.dev.css' ]
        }
      }
    },
    watch: {
      config : {
        files : ['gruntfile.js'],
        options : {
          reload: true
        }
      },
      js: {
        files: ['js/*.js'],
        tasks: ['js']
      },
      css: {
        files: ['less/*.less', 'less/bootstrap/*.less'],
        tasks: ['css']
      }
    }
  });

  grunt.loadNpmTasks('grunt-notify');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-banner');


  grunt.registerTask('default', ['jshint', 'uglify', 'notify', 'less', 'usebanner']);
  grunt.registerTask('js', ['jshint', 'uglify', 'notify' ]);
  grunt.registerTask( 'css', ['less', 'usebanner', 'notify'] );

};
