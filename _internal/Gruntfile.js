module.exports = function(grunt) {
    grunt.initConfig({
        watch: {
            options: { 
                livereload: true 
            },
            view: {
                files: ['../**/*.php', '../**/*.html']
            },
            js: {
                files: ['../js/*.js'],
                // tasks: ['uglify:main']
            },
            sass: {
                files: ['sass/sass/**/*.sass','sass/sass/**/*.scss'],
                // tasks: ['shell:compassCompile']
            },
            css: {
                files: ['../css/*.css','!../css/*.min.css'],
                tasks: ['cssmin:main']
                // files: ['../css/*.css'],

            },
        },
        uglify: {
            options: {
                // mangle: <f></f>alse,
                banner: '/* CREATED ON <%= grunt.template.today("dd-mm-yyyy") %> */\n' + '/* BANNER GOES HERE */\n'
            },
            main: {
                expand: true,
                cwd: '../js/',
                src: ['*.js','!*.min.js'],
                dest: '../js/',
                ext: '.min.js'
            }
        },
        cssmin: {
            options: {
                banner: '/* CREATED ON <%= grunt.template.today("dd-mm-yyyy") %> */\n' + '/* BANNER GOES HERE */\n'
            },
            all: {
                expand: true,
                cwd: '../css/',
                src: ['*.css','!*.min.css'],
                dest: '../css/',
                ext: '.min.css'
            },
            main: {
                expand: true,
                cwd: '../css/',
                src: ['main.css'],
                dest: '../css/',
                ext: '.min.css'
            }
        },
        shell: {
            compassWatch: {
                command: 'compass watch',
                options: {
                    execOptions: {
                        cwd: "sass"
                    }
                }
            },
            compassCompile: {
                command: "compass compile",
                options: {
                    execOptions:{
                        cwd: "sass"
                    }
                }
            },
        },
        concurrent: {
            compassAndWatch: {
                tasks: ['watch','shell:compassWatch'],
                options: {
                    logConcurrentOutput: true
                }
            }
        },
        copy: {
            build: {
                expand: true,
                cwd: '../',
                src: ['**','!**/_internal/**','!**/build/**','!**/css/min/**','!**/js/min/**'],
                dest: '../build'
            }
        },
        clean: {
            build: {
                src: ['../build/**/*','../build'],
                options: {
                    force: true
                }
            },
            internal: {
                src: ['../internal'],
                options: {
                    force: true
                }
            }
        },
    });
 
    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln(target + ': ' +  filepath + ' has ' + action);
    });
 
    grunt.loadNpmTasks('grunt-concurrent');
    grunt.loadNpmTasks('grunt-shell');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('dev', ['concurrent:compassAndWatch']);
    // grunt.registerTask('dev', ['watch']);
    grunt.registerTask('build', ['uglify','cssmin:all','clean:build','copy:build']);
    grunt.registerTask('default', ['watch']);
};