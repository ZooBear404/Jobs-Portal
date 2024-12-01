<?php require("header.php"); ?>

<?php if ($type == 'job_seeker') { ?>

	<div class="flex flex-col gap-5 p-3">

		<div class="grid grid-cols-3 grid-rows-1 gap-5 p-2 bg-slate-600 top">
			
			<div class="flex flex-col col-span-1 gap-1 p-1 overflow-y-auto grid-sa bg-yellow-50 job_seeker-submitted-apps">
				<p class="text-xl">Submitted Applications</p>
				<div class="flex flex-col gap-2 job_seeker-submitted-apps-list">
					<?php
					$job_seeker_id = JobSeekerDatabase\getUserIdFromSessionToken($_SESSION['session_token']);
					$rows = JobSeekerDatabase\getJobApplicationListByJobSeekerId($job_seeker_id);
					if ($rows == 0) {
						echo "<p>No Job Apps</p>";
					} else {
						foreach ($rows as $row) {
							$job_id = $row['job_id'];
							$job_name = JobDatabase\getJobNameById($job_id);
							$job_seeker_info = JobSeekerDatabase\getJobSeekerInfo($row['job_seeker_id']);
							$job_seeker_first_name = $job_seeker_info['first_name'];
							$job_seeker_last_name = $job_seeker_info['last_name'];

							echo "<a href='./crud/job/read.php?id=$job_id' class=''>";
							$job_application_status;
							if ($row["is_accepted" == 'T']) {
								$job_application_status = "accepted";
								echo "<div class='p-1 bg-green-400 hover:bg-yellow-100 job-application job-application-accepted'>";
							} else if ($row["is_reviewed"] == 'T') {
								$job_application_status = "reviewed";
								echo "<div class='p-1 bg-green-100 hover:bg-yellow-100 job-application job-application-reviewed'>";
							} else {
								$job_application_status = "applied";
								echo "<div class='p-1 job-application bg-slate-300 hover:bg-yellow-100'>";
							}

							$time_created = $row['time_created'];
							echo "<div>$job_name</div>";
							echo "<div>$time_created</div></div></a>";
						}
					}
					?>
				</div>
			</div>

			<div class="grid col-span-2 gap-1 p-1 overflow-y-auto bg-stone-200 job_seeker-info">
			<p class="text-xl">Information</p>
			<div class="grid grid-cols-2 gap-1">
				<div class="flex flex-col gap-2 left">
					<?php
					$results = JobSeekerDatabase\getJobSeekerInfo($job_seeker_id);
					$first_name = $results['first_name'];
					$last_name = $results['last_name'];
					$email = $results['email'];
					$date_of_birth = $results['date_of_birth'];
					echo "<p>Firstname: $first_name</p>";
					echo "<p>Lastname: $last_name</p>";
					echo "<p>Email: $email</p>";
					echo "<p>Date of Birth: $date_of_birth</p>";
					?>
				</div>
				<div class="flex flex-col gap-2 overflow-y-auto right">
					<div class="job_seeker-educations">
						<div class="flex justify-between job-seeker-educations-header">
							<p>Education</p>
							<?php
							echo "<a href='crud/job_seeker/education/create.php?id=$job_seeker_id'>";
							?>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" height="20px">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
							</svg>
							</a>
						</div>
						<ul>
							<?php
							$rows = JobSeekerDatabase\getJobSeekerEducationById($job_seeker_id);
							if ($rows == 0) {
								echo "<p>No Education found</p>";
							} else {
								foreach ($rows as $row) {
									$institute_id = $row["institute_id"];
									$institute_name = JobSeekerDatabase\getInstituteNameFromId($institute_id);
									$field_of_study_id = $row["field_of_study_id"];
									$education_level_id = $row["education_level_id"];
									$education_level_name = JobSeekerDatabase\getEducationLevelNameFromId($education_level_id);

									echo "<div class='job-seeker-education'>
											<div class='left-education'>
												<p>$institute_name</p>
												<p>$field_of_study_name</p>
												<p>$education_level_name</p>
											</div>
											<div class='right-education'>
												<a href='crud/job_seeker/education/delete.php?job_seeker_id=$job_seeker_id&id=$institute_id'>d<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='20px'>
												<path stroke-linecap='round' stroke-linejoin='round' d='M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z' />
												</svg></a>

											</div>
										</div>";
								}
							}

							?>

						</ul>
					</div>
					<div class="job-seeker-experiences">
						<div class="flex justify-between job-seeker-experiences-header">
							<p>Experiences</p>
							<?php
							echo "<a href='crud/job_seeker/experience/create.php?id=$job_seeker_id'>";
							?>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" height="20px">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
							</svg>
							</a>
						</div>
						<div class="job-seeker-experiences-list">
							<?php
							$rows = JobSeekerDatabase\getColumnNamesFromTableWithId(['job_experience_id', 'job_title', 'start_date', 'end_date'], 'job_seeker_experience', $job_seeker_id);
							if ($rows == 0) {
								echo "<p>No Experiences Found</p>";
							} else {
								foreach ($rows as $row) {
									$job_experience_id = $row['job_experience_id'];
									$job_title = $row['job_title'];
									$start_date = $row['start_date'];
									$end_date = $row['end_date'];

									if ($end_date == null) $end_date = '_';

									echo "<div class='job-seeker-experience'>
										<div class='job-seeker-experience-left'>
											<p>$job_title</p>
											<div class='job-seeker-experience-left-bottom'>
												$start_date - $end_date
											</div>
										</div>
										<div class='job-seeker-experience-right'>
										<a href='crud/job_seeker/experience/delete.php?job_seeker_id=$job_seeker_id&id=$job_experience_id'>
												<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='20px'>
													<path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
												</svg>
										</a>
										<a href='crud/job_seeker/experience/update.php?job_seeker_id=$job_seeker_id&id=$job_experience_id'>
											<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='20px'>
												<path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
											</svg>
										</a>
										</div>
									</div>";
								}
							}
							?>
						</div>

					</div>
					<div class="job-seeker-skills">
						<div class="flex justify-between job-seeker-skills-header">
							<p>Skills</p>

							<?php
							echo "<a href='crud/job_seeker/skill/create.php?id=$job_seeker_id'>";
							?>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" height="20px">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
							</svg>
							</a>
						</div>
						<div class="job-seeker-skills-list">
							<?php
							$rows = JobSeekerDatabase\getColumnNamesFromTableWithId(['skill_id'], 'job_seeker_skill', $job_seeker_id);
							if ($rows == 0) {
								echo "<p>No Skills Found</p>";
							} else {
								foreach ($rows as $row) {
									$skill_id = $row["skill_id"];
									$row = JobSeekerDatabase\getColumnNamesFromTable(['title'], "skill");
									$skill_name = $row['skill_name'];

									echo "<div class='job-seeker-skill'>
										<div class='job-seeker-skill-left'>
											<p>$skill_name</p>
										</div>
										<div class='job-seeker-skill-right'>
										<a href='crud/job_seeker/skill/delete.php?job_seeker_id=$job_seeker_id&id=$skill_id'>
												<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='20px'>
													<path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
												</svg>
										</a>
										<a href='crud/job_seeker/skill/update.php?job_seeker_id=$job_seeker_id&id=$skill_id'>
											<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='20px'>
												<path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
											</svg>
										</a>
										</div>
									</div>";
								}
							}


							?>
						</div>

					</div>
					<div class="job-seeker-languages">
						<div class="flex justify-between job-seeker-languages-header">
							<p>Languages</p>

							<?php
							echo "<a href='crud/job_seeker/language/create.php?id=$job_seeker_id'>";
							?>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" height="20px">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
							</svg>
							</a>
						</div>
						<div class="job-seeker-languages-list">
							<?php
							$rows = JobSeekerDatabase\getColumnNamesFromTableWithId(['job_seeker_language_id', 'language_id', 'language_fluency_id'], 'job_seeker_language', $job_seeker_id);
							if ($rows == 0) {
								echo "<p>No Languages Found</p>";
							} else {
								foreach ($rows as $row) {
									$job_seeker_language_id = $row["job_seeker_language_id"];
									$language_id = $row["language_id"];
									$language_name = JobSeekerDatabase\getNameByTablePrimaryKey('language', $language_id);
									$job_seeker_language_fluency_id = $row['language_fluency'];
									$fluency_name = JobSeekerDatabase\getNameByTablePrimaryKey('language_fluency', $job_seeker_language_fluency_id);

									echo "<div class='job-seeker-language'>
										<div class='job-seeker-language-left'>
											<p>$language_name</p>
										</div>
										<div class='job-seeker-language-right'>
										<a href='crud/job_seeker/language/delete.php?job_seeker_id=$job_seeker_id&id=$skill_id'>
												<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='20px'>
													<path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
												</svg>
										</a>
										<a href='crud/job_seeker/language/update.php?job_seeker_id=$job_seeker_id&id=$skill_id'>
											<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='20px'>
												<path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
											</svg>
										</a>
										</div>
									</div>";
								}
							}


							?>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="p-1 bg-orange-300 bottom">
			<div class="grid grid-cols-5 p-1 job_seeker-jobs">
					<div class="col-span-1 job-seeker-saved-jobs">
						<p>Saved Jobs</p>
						<?php
						$rows = JobSeekerDatabase\getColumnNamesFromTableWithId(['saved_job_id', 'job_id'], 'saved_job', $job_seeker_id);
						if ($rows == 0) {
							echo "<p>No jobs saved</p>";
						} else {
							foreach ($rows as $row) {
								$job_id = $row['job_id'];
								$job_name = JobSeekerDatabase\getNameByTablePrimaryKey('job', $job_id);

								echo "<a href='crud/job/read.php?id=$job_id'>
									<div>$job_name</div>
								</a>";
							}
						}
						?>

					</div>
					<div class="flex flex-col col-span-4 p-1 jobs">
						<p>Jobs Announced</p>
						<div class="flex flex-col gap-1 overflow-y-visible jobs-announced-list">
							<?php
							$rows = JobDatabase\getJobList();
							if ($rows == 0) {
								echo "<p>No Jobs Announced</p>";
							} else {
								foreach ($rows as $row) {
									$job_id = $row["job_id"];
									$job_name = $row["name"];
									$job_time_created = $row["time_created"];
									$job_close_date = $row["close_date"];
									$job_seeker_id = JobSeekerDatabase\getUserIdFromSessionToken($_SESSION['session_token']);
									$company_id = $row["company_id"];
									// $company_name = JobSeekerDatabase\getNameByTablePrimaryKey("company", $company_id);
									$company_name = CompanyDatabase\getCompanyNameFromId($company_id);
									$company_logo = CompanyDatabase\getCompanyLogoFromId($company_id);

									$images_url = "./static/images/profiles/";
									echo "<div class='flex items-center justify-between p-2 bg-blue-300 align-center'>
										<a href='crud/job/read.php?id=$job_id' class='flex flex-grow gap-2'>
											<img src=$images_url$company_logo class='h-16 w-16 rounded-[50%]'>
											<div>
												<p>$job_name</p>
												<div class='flex gap-2 justify-evenly'>
													<p class=''>Posted: $time_created</p>
													<p>Expires: $job_close_date</p>
												</div>
											</div>
											</a>
											<a href='crud/job/save.php?job_id=$job_id&job_seeker_id=$job_seeker_id'>Save</a>
										</div>";
								}
							}

							?>
						</div>
					</div>
				</div>
			</div>
	</div>

<?php } else if ($type == 'company') { ?>
	<div class="flex flex-col items-center gap-5 p-5">
		<div class="w-full p-3 bg-blue-400 rounded-md h-96 top">
			<div class="flex flex-col gap-2 company-jobs-container">
				<p class="text-3xl company-jobs-header">Jobs Posted</p>
				<div class="flex flex-col gap-1 p-2 overflow-y-auto company-jobs-list">
					<?php
					$company_id = CompanyDatabase\getCompanyIdFromSessionToken($_SESSION['session_token']);
					$rows = CompanyDatabase\getListOfJobsPostedByCompanyId($company_id);
					if ($rows == 0) {
						echo "<p class='text-2xl'>No Jobs Posted</p>";
					} else {
						foreach ($rows as $row) {
							$job_id = $row["job_id"];
							$job_name = $row["name"];
							$job_applications = CompanyDatabase\getNumberOfJobApplicationsForJobId($job_id);

							echo "<a href='crud/job_application/job_applicants.php?id=$job_id' class='p-1 rounded-md bg-zinc-100 hover:bg-zinc-200 active:bg-zinc-300'>
									<div class='company-job'>
									<p class='company-job-name'>Job: $job_name</p>
									<p class='company-job-applicants'> Applicants: " . $job_applications[0]['total_rows'] . " </p>
									</div>
								</a>";
						}
					}
					?>
				</div>
			</div>
		</div>
		<a href="crud/job/create.php">
		<div class="flex items-center justify-center w-32 h-16 p-3 rounded-md bg-slate-300 bottom">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" height="100px">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
				</svg>
			</div>
		</a>
	</div>

<?php } else if ($type == 'admin') { ?>
	<div class="grid grid-cols-2 grid-row-2">
		<div class="flex flex-col gap-2 p-4 top">
			<div class="flex flex-col gap-2 p-3 rounded-md admin-job-seeker-container bg-lime-200">
				<p class="text-xl admin-job-seeker-header">Job Seekers</p>
				<div class="flex flex-col gap-2 overflow-y-auto admin-job-seeker-list">
					<?php
					$images_url = "./static/images/profiles/";

					$rows = AdminDatabase\getJobSeekerList();
					if ($rows == 0) {
						echo "Not Found";
					} else {
						foreach ($rows as $row) {
							$job_seeker_id = $row["job_seeker_id"];
							$profile_image = JobSeekerDatabase\getUserImageUrlFromId($job_seeker_id);
							$first_name = $row['first_name'];
							$last_name = $row['last_name'];
							echo "<div class='flex justify-between gap-2 p-2 rounded-md bg-emerald-200 admin-job-seeker'>
									<div class='flex items-center gap-2'>
										<img src='$images_url$profile_image' class='h-10'>
										<p>$first_name $last_name</p>
									</div>
									<div>
										<a href='crud/job_seeker/delete.php?id=$job_seeker_id'>
										<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
										</svg>
										</a>
										<a href='crud/job_seeker/update.php?id=$job_seeker_id'>
										<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
										</svg>
										</a>
									</div>
								</div>";
						}
					}
					?>
				</div>
			</div>
			<div class="flex flex-col gap-2 p-3 rounded-md admin-jobs-container bg-lime-200">
				<p class="text-xl admin-jobs-header">Jobs</p>
				<div class="flex flex-col gap-2 overflow-y-auto admin-jobs-list">
					<?php

					$rows = AdminDatabase\getJobsList();

					if ($rows == 0) {
						echo "Jobs not found";
					} else {

						foreach ($rows as $row) {
							$job_id = $row["job_id"];
							$job_name = $row["name"];
							$company_id = $row["company_id"];
							$company_name = CompanyDatabase\getCompanyNameFromId($company_id);
							$company_logo = CompanyDatabase\getCompanyLogoFromId($company_id);

							echo "<div class='flex justify-between gap-2 p-2 rounded-md admin-job bg-emerald-200 '>
									<div class='flex items-center gap-2'>
										<img src='$images_url$company_logo' class='h-10'>
										<p>$job_name</p>
										</div>
									<div>
										<a href='crud/job/delete.php?$job_id'>
										<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
										</svg>
										</a>
										<a href='crud/job/update.php?$job_id'>
										<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
										</svg>
										</a>
									</div>
								</div>";
						}
					}
					?>

				</div>
			</div>
		</div>
		<div class="flex flex-col gap-2 p-4 bottom">
			<div class="flex flex-col gap-2 p-3 rounded-md admin-job-applications-container bg-lime-200">
				<p class="text-xl admin-job-applications-header">Job Applications</p>
				<div class="flex flex-col gap-2 overflow-y-auto admin-job-applications">
					<?php
					$rows = AdminDatabase\getJobApplicationsList();
					if ($rows == 0) {
						echo "<p>No Job Apps Found</p>";
					} else {
						foreach ($rows as $row) {
							$job_application_id = $row["job_application_id"];
							$job_id = $row["job_id"];
							$job_name = JobDatabase\getJobNameById($job_id);
							$job_seeker_id = $row["job_seeker_id"];
							$job_seeker_name = JobSeekerDatabase\getJobSeekerNameById($job_seeker_id);
							$job_seeker_image_path = JobSeekerDatabase\getUserImageUrlFromId($job_seeker_id);

							echo "<div class='flex justify-between gap-2 p-2 rounded-md bg-emerald-200 admin-job-application'>
									<p>$job_name</p>
									<div class='flex gap-2'>
										<img src='$images_url$job_seeker_image_path' class='h-10'>
										<div>
											<p>$job_seeker_name[0] $job_seeker_name[1]</p>
										</div>
										<a href='crud/job_application/delete.php?$job_application_id'>
									<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
									</svg>
									</a>
									<a href='crud/job_application/update.php?$job_application_id'>
									<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
									</svg>
									</a>
									</div>
								</div>";
						}
					}


					?>
				</div>
			</div>
			<div class="flex flex-col gap-2 p-3 rounded-md admin-company bg-lime-200">
				<p class="text-xl admin-company-header">Companies</p>
				<div class="flex flex-col gap-2 overflow-y-auto admin-company-container">
					<?php
					$rows = AdminDatabase\getCompaniesList();
					if ($rows == 0) {
						echo "<p>No Companies Found</p>";
					} else {
						foreach ($rows as $row) {
							$company_id = $row["company_id"];
							$company_name = $row["name"];
							$company_logo = CompanyDatabase\getCompanyLogoFromId($company_id);
							echo "<div class='flex justify-between gap-2 p-2 rounded-md admin-single-company bg-emerald-200'>
									<div class='flex items-center gap-2'>
										<img src='$images_url$company_logo' class='h-10'>
										<div>
										<p>$company_name</p>
										</div>
									</div>
									<div class='flex items-center gap-2'>
										<a href='crud/company/delete.php?$company_id'>
										<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
										</svg>
										</a>
										<a href='crud/company/update.php$company_id'>
										<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6' height='30px'>
										<path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
										</svg>
										</a>
									</div>
								</div>";
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>

<?php } else { ?>
	<div class="no-login-container">
		<div class=" job_seeker-jobs">
			<div class="flex items-center justify-center job-seeker-jobs-announced">
				<div class="flex flex-col gap-5 p-3 bg-indigo-300 rounded-md w-96 jobs">
					<p class="text-xl">Jobs Announced</p>
					<div class="flex flex-col gap-2 jobs-announced-list">
						<?php
						$rows = JobDatabase\getJobList();
						if ($rows == 0) {
							echo "<p>No Jobs Announced</p>";
						} else {
							foreach ($rows as $row) {
								$job_id = $row["job_id"];
								$job_name = $row["name"];
								$job_time_created = $row["time_created"];
								$job_close_date = $row["close_date"];
								$company_id = $row["company_id"];
								$company_name = JobSeekerDatabase\getNameByTablePrimaryKey("company", $company_id);
								$company_logo = CompanyDatabase\getCompanyLogoFromId($company_id);
								$images_url = "./static/images/profiles/";

								echo "<div class='flex job'>
									<a href='crud/job/read.php?id=$job_id' class='flex justify-between gap-5'>
										<img src=$images_url$company_logo class='h-12 rounded-[50%]'>
										<div class='left'>
											<div class='job-information'>
												<p> $job_name </p>
												<p> $job_close_date </p>
											</div>
										</div>
									</a>
									</div>";
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>