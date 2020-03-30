var searchBar = document.getElementById('searchbar');
var matchList = document.getElementById('matchList');

var searchFunction = async searchText => {
	
	const res = await fetch("http://127.0.0.1/coursesapi");
	const states = await res.json();
	let matches = states.filter(state => {
		const regex = new RegExp(`${searchText}`, 'gi');
		return state.title.match(regex) || state.description.match(regex) || state.skillsToGain.match(regex) || state.category.match(regex) || state.tags.match(regex);
	});
	if (searchText.length === 0) {
		matches = [];
	}

	if(matches.length > 0) {
		const html = matches.map(match => `
			<div style="max-width: 50%; margin-left:25%; margin-right:25%; opacity:0.5;">
				<h6><a href='../course/${match.title.replace(/ /g,"-")}'>${match.title}</a></h6>
				<small>${match.tags} , created at : ${match.created_at}</small>
				<hr/>
			</div>
		`).join('');
		matchList.innerHTML = html;
	}
}
searchBar.addEventListener("input",() => searchFunction(searchbar.value));
