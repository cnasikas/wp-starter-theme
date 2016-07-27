module.exports = function (grunt) {
grunt.initConfig({

    uglify: {
        dist: {
            src: ['assets/js/vendor/*.js', 'assets/js/*.js'],
            dest: 'assets/js/app.min.js'
        }
    },

    sass: {
        dev: {
            options: {
                style: 'expanded',
                compass: false
            },
            files: {
                'assets/css/main.css': 'assets/sass/main.scss'
            }
        },
        dist: {
            options: {
                style: 'compressed',
                compass: false
            },
            files: {
                'assets/css/app.min.css': 'assets/sass/main.scss'
            }
        }
    },

    watch: {
        sass: {
            files: 'assets/sass/{,*/}*.{scss,sass}',
            tasks: ['sass:dev']
        }
    },

    imagemin : {
            production : {
                files : [
                    {
                        expand: true,
                        cwd: 'assets/img',
                        src: '**/*.{png,jpg,jpeg}',
                        dest: 'images'
                    }
                ]
            }
        },

        // SVG min
        svgmin: {
            production : {
                files: [
                    {
                        expand: true,
                        cwd: 'assets/img',
                        src: '**/*.svg',
                        dest: 'images'
                    }
                ]
            }
        }
});

// load plugins
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-contrib-sass');
grunt.loadNpmTasks('grunt-svgmin');
grunt.loadNpmTasks('grunt-contrib-imagemin');

// register at least this one task
grunt.registerTask('default', [ 
    'sass:dist',
    'imagemin:production',
    'svgmin:production',
    'uglify'
]);

};