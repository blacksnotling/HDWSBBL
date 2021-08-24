function UpdateSPP(theId) {
  /*		Calcuate the players SPP		*/
  var tot_td = document.getElementById('bblm_td' + theId).value * 3;
  var tot_cas = document.getElementById('bblm_cas' + theId).value * 2;
  var tot_comp = document.getElementById('bblm_comp' + theId).value * 1;
  var tot_int = document.getElementById('bblm_int' + theId).value * 2;
  var tot_mvp = document.getElementById('bblm_mvp' + theId).value * 5;
  var tot_spp = tot_td + tot_cas + tot_comp + tot_int + tot_mvp;
  document.getElementById('bblm_spp'+ theId).value = tot_spp;

  /*		Highlight and fill Increase Box		*/
  var inc_col = "#5EFB6E"
  var old_spp = document.getElementById('bblm_oldspp' + theId).value;
  var new_SPP = Number(old_spp) + Number(tot_spp);
  if (((old_spp) <= 5) && new_SPP > 5) {
    document.getElementById('bblm_increase' + theId).style.backgroundColor = inc_col;
    document.getElementById('bblm_increase' + theId).value = "[Skill]";
  }
  else if (((old_spp) <= 15) && new_SPP > 15) {
    document.getElementById('bblm_increase' + theId).style.backgroundColor = inc_col;
    document.getElementById('bblm_increase' + theId).value = "[Skill]";
  }
  else if (((old_spp) <= 30) && new_SPP > 30) {
    document.getElementById('bblm_increase' + theId).style.backgroundColor = inc_col;
    document.getElementById('bblm_increase' + theId).value = "[Skill]";
  }
  else if (((old_spp) <= 50) && new_SPP > 50) {
    document.getElementById('bblm_increase' + theId).style.backgroundColor = inc_col;
    document.getElementById('bblm_increase' + theId).value = "[Skill]";
  }
  else if (((old_spp) <= 75) && new_SPP > 75) {
    document.getElementById('bblm_increase' + theId).style.backgroundColor = inc_col;
    document.getElementById('bblm_increase' + theId).value = "[Skill]";
  }
  else if (((old_spp) <= 150) && new_SPP > 175) {
    document.getElementById('bblm_increase' + theId).style.backgroundColor = inc_col;
    document.getElementById('bblm_increase' + theId).value = "[Skill]";
  }
}