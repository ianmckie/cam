module.exports = function(grunt) {
	grunt.initConfig({
		sass: {
			dist: {
			  options: {
				style: 'expanded'
			  },
			  files: {
				'css/main.css': 'css/scss/main.scss',
			  }
			}
		},
		watch: {
			css: {
				files: 'css/scss/*.scss',
				tasks: ['sass'],
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['sass']);
};