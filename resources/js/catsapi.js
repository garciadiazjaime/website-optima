var catsapi = {
    type: "macintosh",
    color: "red",

    get_joborders_fe: function () {
        show_loading('js_jobs_list')
        $.get('catsapi_c/get_joborders_fe', {}, function(data) {
        	$('#js_jobs_list').html(data)
		});
    },

    get_joborders_talent: function (search = '', num = '0') {
        //console.log(search + " " + page)
        show_loading('js_job_list')
        $.get(server + 'catsapi_c/get_joborders_talent/', {num: num, search: search}, function(data) {
            $('#js_job_list').html(data)
        });
    },
}

