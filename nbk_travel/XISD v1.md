WORK-INTERGRATED LEARNING

TASK 1- PROJECT PLAN

SHUTTLE BOOKING MANAGEMENT SYSTEM

&#x20;

 

Full Name	Student Number 	Role

Shenice Wood

&#x09;ST10447209	Project Manager

Murendeni Makhavhu	ST10377430	Software Developer

Thandiwe Sibeko

&#x09;ST10446961	System Analyst

Matome Maopye

&#x09;ST10341694	Tester/ Frontend dev

Mzamo Richmond Ndlovu

&#x09;ST10455453	Software Developer











































Table of Contents

1\.  Introduction	                                                                                                                                     3, 4 

2\.  Milestones and Deliverables	                                                                                                            5

3\.  Work Breakdown Structure	                                                                                                       6, 7

4\.  Project Schedule (Gantt Chart)	                                                                                                            8

5\.  Risk Management                                                                                                                                   9, 10

6\.  Technical Feasibility	                                                                                                                 11, 12  

7\.  Economic Feasibility	                                                                                                                  13,14

8\.  Team Members	                                                                                                                                15,17

Appendix A, B, C, D  	                                                                                                                                       18











&#x20;

1.INTRODUCTION

The document presented outlines the Project Plan for the Shuttle Booking Management System, a software solution developed to meet operational requirements of a small shuttle service company. This plan is directed to the company’s management and serves as a formal justification and roadmap for development efforts.

1.1	Customer Needs

The client currently manages all transport bookings manually, through direct phone calls, paper registry, and personal spreadsheets. This leads to:

•	Double-bookings and scheduling conflicts, leading to duplications of valuable information.

•	No centralised customer record system, making repeat-client management difficult

•	Inability to generate valuable reports for business decisions

The Shuttle Booking Management System addresses these problems by proving a website booking management platform with scheduling, customer records, and generative reports.



1.2	Project Goals

•	Develop a fully functional Booking Management to capture and store all trip bookings

•	Implement a Scheduling System that assigns drivers and vehicles, preventing conflicts

•	Create a database to track clients, potential clients, repeat clients and booking history

•	Deliver a Basic Reporting module for trips per day/week and revenue summaries

•	Invoice Generator, and Notification Simulation



1.3 Cost Constraints

The project is developed within an academic WIL coursework, meaning no direct monetary budget is allocated for commercial tools. All software resources will be open source. The budget has been expressed in effort (person-hours) as detailed in 7. Economic Feasibility.  A generative budget estimate totalling R 62,480 has been computed based on team member estimated per hour.



1.4	Risks

Key risks to the project include, but are not limited to:

•	Failure to deliver the system on time may result in a poor academic grade and missed assessment deadlines.

•	Technical failures or lack of expertise in chosen technologies could delay development.

•	Team member absence or member withdrawal resulting in reduced capacity

•	Scope creep due prioritization of optional features over core deliverables

•	Late or incomplete deliverables impacting final assessment mark

Full risk analysis, probability ratings, and mitigation strategies are contained in 5. Risk Management.



1.5	 Customer Benefits

Upon successful completion of the project, the client will incur the following benefits.

•	Prevention of double bookings and scheduling clashes

•	A centralised digital record of all customers and trips

•	Ability to automate and generate reports, imperative for business intelligence

•	Real-time visibility for all stakeholders, improving trust and transparency in the shuttle service.





 

2\. Milestones and Deliverables

The following table outlines the key milestones for the Shuttle Booking System project and their associated deliverables. Each milestone represents a significant achievement in the development lifecycle (Project Management Institute, 2021).



•	Project Initiation – Clearly defined team roles, communication plan

•	Requirements Gathering Complete – Software Requirements Specification document

•	System Design Complete – Database ERD and UI wireframes

•	Development Environment Setup – version control (GitHub) repo created

•	Database Implementation Complete – Database structure created based on design

•	Frontend Prototype Complete – Working HTML/CSS/JS prototype with navigation

•	Backend – Development, testing, and documentation of backend logic

•	Testing – report with test cases and results

•	Documentation – Keep records of the development Project documentation submission Final project report, user manual, presentation slides







































3\.  Work Breakdown Structure

The WBS below breaks the project into manageable tasks, detailing description, duration, predecessor tasks, responsible team members, and required resources (Project Management Institute, 2021).



Task Name 	Description	Duration	Predecessor	Responsible	Resources 

Project Initiation	Define scope, objectives, team roles, and communication channels.

&#x09;2 weeks	-	 	All members	Meeting tools, shared documents

Requirements Analysis	Gather and document functional \& non-functional requirements via stakeholder interviews.

&#x09;2 weeks	Project Initiation	Shenice \& Matome	Interview notes, stakeholder engagement

System Design	Design system architecture, database schema (ERD), and UI wireframes.	2 weeks	Requirements Analysis	Thandiwe \& Murendeni	Draw.io

Dev Environment Setup	Install and configure development tools, set up GitHub repository and CI pipeline.	1 weeks	Requirements Analysis	Shenice \& Mzamo	VS Code, Git, GitHub



Database Development	ERD and database schema define	2 weeks	System Design, Dev Environment Setup	Mzamo, Matome \& shenice	Draw.io / Lucidchart, phpMyAdmin, MS Word

Frontend Development

&#x09;Build responsive UI pages: login, booking, dashboard, route management using HTML/CSS/JS or React.	3 weeks	System Design, Dev Environment Setup	Murendeni, Thandiwe \& Mzamo	VS Code, HTML,

Backend Development	Development, testing, and documentation of backend logic	3 weeks	Database Development, Development	Matome, Mzamo, Shenice	PHP, Python, Chrome/Edge

Testing	log and fix defects.	2 weeks	Backend Development	Mzamo \& Murendeni	Test cases, and debugging tools

Documentation	Preparation of final report, user manual, and presentation slides 

&#x09;2 weeks	Testing	Murendeni \& Thandiwe	MS Word, PowerPoint  

Submissions	Conduct final review, submit all deliverables, and hold a retrospective meeting 

&#x09;1 week	Documentation	All members	MS Word, Submission portal





 

4\.  Project Schedule (Gantt Chart)

The Gantt chart below provides a visual timeline of the Campus Shuttle Booking System project across 12 weeks

&#x09;W1	W2	W3	W4	W5	W6	W7	W8	W9	W10	W11	W12

Project Initiation 												

Requirement Analysis												

System design 												

Environment setup												

Database development						

&#x09;

&#x09;				

Frontend development 							

&#x09;				

Backend development												

Testing 												

Documentation 												

Submissions 												

 

5\.  Risk Management

Risk management is the process of identifying, assessing, and overseeing potential problems that could impact a project, and planning how to lower their impact (Project Management Institute, 2021).

The following table identifies potential risks to the project, their likelihood and impact, and the proactive mitigation strategies to be employed. Probability and Impact are rated: Very Low, Low, Medium, High, Very High.



Risk 	Probability	Impact 	Proactive steps 

Team member withdraws from project 	Medium 	Very high 	Assign backup roles before work begins, share documents so that any team member can pick up other’s tasks 

No cooperation from client/sponsor 	Low	High 	Hold bi-weekly check-ins, agree on feedback, rely on documented requirements to reduce day-to-day dependency on client input 

Lack of technical expertise	Medium 	High 	Identify skill gaps early, schedule learning time, and use reliable libraries/tools.

Running behind schedule	Medium 	High 	Run weekly sprint reviews, prioritise MVP features first, drop optional features from scope if core work is at risk 

Team member does not contribute equally 	Medium	Medium 	Track contributions using GitHub and task boards; escalate issues if necessary.

Scope creep (optional features consuming core time)	High	High 	Lock scope at the design milestone, optional features may only start once all core modules has pass through 

Data loss/ version control conflicts	Low	High 	Use GitHub with branches, pull requests, and regular commits.

Tool/software unavailability	Low	Medium 	Use free/open-source tools and prepare alternative software options in advance.

Failure to meet academic submission deadline	Low 





&#x09;Very high	Develop documentation alongside coding and submit drafts early for feedback.





 

6\.  Technical Feasibility

Technical feasibility is the evaluation of whether the required hardware and software are available and are adequate to successfully develop and run the system (Project Management Institute, 2021).

6.1 Hardware Resources

Hardware Resources 	Availability

Development Laptops



&#x09;Available, all members own laptops as the course specifies so.

Internet Connection



&#x09;Available, Provide for by Rosebank College and personal home WIFI

Backup Storage



&#x09;Available. OneDrive used for backup, provide for by Rosebank College.

Institutional Lab Computers (optional)

&#x09;Available – campus computer labs accessible during operating hours.



6.2 Hardware Resources

Software	Purpose	Availability

VS Code	IDE for all development	Available (FREE), installed on all computers and provided for by Rosebank College

GitHub	Version control and code repository	Available (FREE) all team members have accounts



Figma	UI wireframing and design	Available (FREE) web-based, no install needed



Draw.io	Architecture and ER diagrams	Available (FREE) web-based, no install needed



Html2pdf.js	Client-side PDF generation for invoices

&#x09;

Available via npm / CDN





MS Teams	Facilitates communication and team meetings	Available provide for by Rosebank college accounts





Plain HTML/CSS/JS	Frontend framework for building the user interface.	Available FREE via npm or CDN

&#x20;

All identified hardware and software resources are currently available to the development team at no additional cost. No procurement actions are required prior to project commencement. All resources are provided for either by Rosebank College or are Free.





















































7\.  Economic Feasibility

Economic feasibility is the evaluation of whether the project’s benefits outweigh its costs and if it is financially sensible to proceed (Project Management Institute, 2021).

The economic feasibility of the project is assessed using a rough estimate based on team effort. All costs relate exclusively to human effort (person-hours), as all hardware and software resources are available at no direct cost. The relationship used is: 1 session = 40 hours.

Task Name	Team member(s) responsible 	Time allocated per task per team member	Tariff per team member in Rands per hour 	Cost per task (time \* tariff)

Project Initiation 	All team members	40 hours 	R150	R6 000

Requirement Analysis	Shenice \& Matome	40 hours 	R150	R6 000

System design 	Thandiwe \& Murendeni	80 hours	R150	R12 000

Environment setup	Shenice \&  Mzamo 	40 hours	R150	R6 000

Database development	Mzamo, Matome \& shenice	40 hours	R150	R6 000

Frontend development 	Murendeni, Thandiwe \& Mzamo	120 hours	R150	R18 000

Backend development	Matome, Mzamo, Shenice	120 hours	R150	R18 000

Testing 	Mzamo \& Murendeni	80 hours	R150	R12 000

Documentation 	Murendeni \& Thandiwe	40 hours	R150	R6 000

Submissions 	All team members	40 hours 	R150	R6 000

Total Budget For Project				R96 000























































8\. Team Members

Project Lead: Shenice Wood

Role Description: Scope management, scheduling, stakeholder engagement, risk analysis, and final deliverable sign-off.



&#x20;





&#x20;System Analyst: Thandiwe Sibeko

Role Description: Requirements elicitation, use case modelling, ERDs, feasibility analysis, and UAT support

&#x20;











Tester/ UI/UX Designer: Matome Maopye

Role Description: Split clearly into UI/UX design responsibilities (prototypes, accessibility, responsive design) and testing responsibilities (test plans, defect tracking).

&#x20;





DBA: Murendeni Makhavhu

Role Description: Schema design, query optimisation, data integrity, and security.

&#x20;













Software Developer: Mzamo Ndlovu





 

9\. Appendix

Appendix A: References

Project Management Institute. (2021). A Guide to the Project Management Body of Knowledge (PMBOK Guide), 7th Edition. PMI.





Appendix B: Team Consultation Platforms

Channel 	Purpose

WhatsApp Group

&#x09;Urgent communication

Outlook	

&#x09;Formal academic communication







































Appendix C: Team CVs

&#x20;

&#x20;

&#x20;

===This is Module Mannual===



IIE Module Manual                                                      

XISD5319/w 

DIPLOMA IN IT IN SOFTWARE DEVELOPMENT 

XISD5319/w 

WORK INTEGRATED LEARNING 3A 

MODULE MANUAL 2026 

(First Edition 2019) 

This manual enjoys copyright under the Berne Convention. In terms of the Copyright 

Act, no 98 of 1978, no part of this manual may be reproduced or transmitted in any 

form or by any means, electronic or mechanical, including photocopying, recording or 

by any other information storage and retrieval system without permission in writing 

from the proprietor. 

The Independent Institute of Education (Pty) Ltd is registered 

with the Department of Higher Education and Training as a 

private higher education institution under the Higher Education 

Act, 1997 (reg. no. 2007/HE07/002). Company registration number:  1987/004754/07. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 1 of 73 

IIE Module Manual                                                      

XISD5319/w 

DID YOU KNOW? 

Student Portal 

The full-service Student Portal provides you with access to your academic 

administrative information, including: 

 

 

 

 

 

an online calendar, 

timetable, 

academic results, 

module content, 

financial account, and so much more! 

Module Guides or Module Manuals 

When you log into the Student Portal, the ‘Module Information’ page displays the 

‘Module Purpose’ and ‘Textbook Information’ including the online ‘Module Guides or 

‘Module Manuals’ and assignments for each module for which you are registered. 

Supplementary Materials 

For certain modules, electronic supplementary material is available to you via the 

‘Supplementary Module Material’ link. 

Module Discussion Forum 

The ‘Module Discussion Forum’ may be used by your lecturer to discuss any topics 

with you related to any supplementary materials and activities such as ICE, etc. 

To view, print and annotate these related PDF documents, download Adobe 

Reader at following link below: 

https://www.adobe.com/acrobat/pdf-reader.html  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 2 of 73 

IIE Module Manual                                                      

XISD5319/w 

IIE Library Online Databases  

The following Library Online Databases are available. These links will prompt you for 

a username and password. Use the same username and password as for student 

portal. Please contact your librarian if you are unable to access any of these. Here 

are links to some of the databases: 

Library Website 

LibraryConnect 

(OPAC) 

EBSCOhost  

EBSCO eBook 

Collection 

SABINET 

DOAJ 

DOAB 

IIESPACE 

Emerald 

HeinOnline 

JutaStat 

This library website gives access to various online 

resources and study support guides  

\[Link] 

The Online Public Access Catalogue. Here you will be able 

to search for books that are available in all the IIE campus 

libraries.  

\[Link] 

This database contains full text online articles.  

\[Link] 

This database contains full text online eBooks. 

\[Link] 

This database will provide you with books available in other 

libraries across South Africa.  

\[Link] 

DOAJ is an online directory that indexes and provides 

access to high quality, open access, peer-reviewed journals.  

\[Link] 

Directory of open access books. 

\[Link] 

The IIE open access research repository 

\[Link] 

Emerald Insight 

\[Link] 

Law database  

\[Link] 

Law database 

\[Link] 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 3 of 73 

IIE Module Manual                                                      XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                        Page 4 of 73 

Table of Contents 

&#x20;

1\. Introduction ........................................................................................................ 5 

2\. The Purpose of WIL ........................................................................................... 5 

3\. Assessment of WIL ............................................................................................ 6 

4\. Qualification Summary ....................................................................................... 8 

5\. Module Summary .............................................................................................. 9 

6\. Pacer ............................................................................................................... 10 

7\. WIL Requirements ........................................................................................... 14 

8\. Detailed WIL Requirements ............................................................................. 17 

8.1 Task 1 ...................................................................................................... 17 

8.2 Task 2 ...................................................................................................... 21 

8.3 Project Report .......................................................................................... 30 

9\. WIL Mark Breakdown ...................................................................................... 32 

ANNEXURE A – Declaration of Authenticity ............................................................ 33 

ANNEXURE B - Peer Evaluation ............................................................................. 35 

ANNEXURE C - Self-Reflective Report ................................................................... 36 

ANNEXURE D - Project Rubric ............................................................................... 42 

ANNEXURE E – Presentation Rubric ...................................................................... 54 

ANNEXURE F – Group Presentation Rubric ........................................................... 57 

ANNEXURE G - Professional Conduct in the Workplace......................................... 62 

&#x20;

&#x20;

&#x20; 

IIE Module Manual                                                      

XISD5319/w 

1\. Introduction 

An essential part of The Independent Institute of Education (The IIE) qualifications is 

to prepare students for the World of Work. The key differences between WIL modules 

and all other modules in a qualification is that, in the WIL module, you need to use all 

the knowledge and skills that you have developed in all your modules up to that point 

and further develop your abilities to reflect on yourself and your peers.  

2\. The Purpose of WIL 

The purpose of having a WIL module in a qualification is to bring together all the 

knowledge and skills gained into one consolidated project thereby enabling you, the 

student, to integrate what you have learnt in several modules and demonstrate that 

you are able to apply it to solve a workplace type problem. Through the WIL Modules 

additional attention can be given to what SAQA calls Critical Crossfield Outcomes 

(CCFOs) or what is now more generally known internationally as global competencies.  

CCFO1: Identify and solve problems in which responses demonstrate that 

responsible decisions using critical and creative thinking have been made.  

CCFO2: Work effectively with others as a member of a team, group, organisation, 

community.  

CCFO3: Organise and manage oneself and one’s activities responsibly and 

effectively.  

CCFO4: Collect, analyse, organise and critically evaluate information.  

CCFO5: Communicate effectively using visual, mathematical and/or language skills 

in the modes of oral and/or written presentation.  

CCFO6: Use science and technology effectively and critically, showing responsibility 

towards the environment and health of others.  

CCFO7: Demonstrate an understanding of the world as a set of related systems by 

recognising that problem-solving contexts do not exist in isolation.  

CCFO8: In order to contribute to the full personal development of each learner and 

the social and economic development of the society at large, it must be the 

underlying intention of any programme of learning to make an individual 

aware of the importance of:  

 

 

 

 

 

reflecting on and exploring a variety of strategies to learn more 

effectively. 

participating as responsible citizens in the life of local, national and 

global communities. 

being culturally and aesthetically sensitive across a range of social 

contexts. 

exploring education and career opportunities; and 

developing entrepreneurial opportunities.  

The application of CCFOs or global competencies is largely context and discipline 

dependent.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 5 of 73 

IIE Module Manual                                                      

XISD5319/w 

3\. Assessment of WIL 

Assessment of Work-Integrated Learning (WIL) should be based on the design of the 

learning component of the programme, expectations, and stated outcomes. In addition, 

the assessment of WIL is governed by the principles in The IIE Assessment Strategy 

and Policy (IIE009). 

Attendance of the weekly collaborative sessions with the lecturer and with your group 

is required. For distance students, your participation will be done using Microsoft 

Teams or Zoom. 

3.1 

WIL Project 

Your WIL project will consist of a collection of reports, evidence and materials that 

illustrate your skills and capabilities. The project includes reflecting on the learning 

process for one or both of the following purposes: 

o 

o 

To demonstrate student competence during a WIL process by putting together 

evidence of what they did, for example, documentation, background research, 

reflections, lessons learnt, etc. This would include all types of WIL e.g. Project, 

Simulation, Work Placement. 

To keep in one place, some of the documents students may wish to show a 

potential employer as evidence of their learning. 

There are three (3) submissions for the WIL. Task 1, Task 2 and the final Project. Each 

of these submissions are weighted differently and must be done on Arc. 

Your submissions can include Microsoft 365 Office documents such as Visio, Project, 

PowerPoint, Excel and Word. The final submission of the portfolio will be after the 12th 

week in the semester – normally in week 13. Submission of the portfolio is done on 

Arc.  

3.2 

Peer/Self-Evaluations  

Because reflection is such an important part of the WIL modules, students will be 

assessed on their reflections and insights gained while engaging in work-like activities. 

Students will be assessed both on their ability to reflect on themselves (called a “self

learning evaluation”) and on their ability to evaluate other students, or their peers 

(called a “peer evaluation”) in the group. All the self-learning evaluations and peer 

evaluations will be standardised across all the WIL modules and will be weighted 

differently across the various years in a three-year qualification. The students are to 

complete the peer evaluation questionnaire (Annexure B) and the self-evaluation 

reflective report (Annexure C).  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 6 of 73 

IIE Module Manual                                                      

XISD5319/w 

3.3 

Presentations 

All WIL modules require students to deliver a presentation describing their project or 

activity to their peers and/or lecturer(s). This will typically happen at the end of the 

project, i.e., towards the end of the WIL module. Each student in the group is to be 

evaluated according to the presentation rubric (Annexure F).  

The presentation for contact students can be done in front of the lecturer and peers, 

and for distance students, the presentation will be done over Zoom or Microsoft Teams.  

There are two main components of presentations, namely, a verbal component and a 

visual component. The verbal component focuses on the oral, or spoken, portion of 

the presentation during which aspects such as tone, delivery, language, and audience 

engagement are assessed. 

The visual component includes all other communication aids that are used during the 

presentation, e.g., slides, video clips, posters, handouts, models, simulations, 

diagrams, websites, etc. The visual images created by the students themselves may 

be included here if they are relevant to the environment that is being represented. A 

typical example would be when a group of students are discussing the presentation of 

a proposal to a prospective client. Visual aids used in presentations should be used 

effectively. For example, PowerPoint slides should support the presentation but not 

become the presentation. Consequently, students need to think about both what they 

say, how they say it, what they use to support what they say, and how they are acting 

professionally and appropriately in a work-like environment.  

3.4 

WIL Role Players 

WIL involves the following role players:  

1\. 

2\. 

3\. 

The student – the student is expected to attend all scheduled sessions (in 

person or in the case of distance students remotely), to meet deadlines, and 

collect and prepare evidence aligned to expectations as set out in the relevant 

WIL Module Manual. If a letter is required to contact stakeholders from the 

industry, the student must request such letters from the WIL Coordinator. 

The WIL Coordinator – takes responsibility for the overall operationalisation of 

WIL on a campus or for a group of students and issues any formal letters required 

by the student. 

IIE approved lecturers – designated to guide, mentor, assess and monitor 

students’ academic progress in the WIL module. 

A lecturer responsible for a WIL module may also be the designated WIL Coordinator. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 7 of 73 

IIE Module Manual                                                      

XISD5319/w 

4\. Qualification Summary 

Qualification Name: Diploma in IT in Software Development 

Qualification Code: DISD0601 

QUALIFICATION PURPOSE 

EXIT LEVEL OUTCOMES 

The purpose of this qualification is to 

produce software developers with a 

variety of skills in different programming 

paradigms including, in particular, 

creative, critical thinking and problem

solving skills. Students will develop 

sound knowledge of programming in the 

desktop mobile and web 

environment.  The programme includes 

different programming languages as 

well as system logic, architecture and 

design.  

ELO01. Demonstrate applied 

competence in the analysis and 

design of software solutions to 

meet specific business 

requirements. 

ELO02. Integrate programming, 

database and web development 

techniques in creating 

applications for a business 

environment. 

ELO03. Demonstrate an ability to use a 

variety of programming tools 

and techniques to develop 

secure computer applications for 

a business. 

ELO04. Apply generally accepted 

coding best practice in the 

development of secure software 

solutions. 

ELO05. Test and quality assure 

software applications. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 8 of 73 

IIE Module Manual                                                      XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                        Page 9 of 73 

5\. Module Summary  

&#x20;

ITEM DESCRIPTION 

Faculty Faculty of ICT 

Qualification Diploma in Information Technology in Software Development 

Module Name Work Integrated Learning 3A (WIL) 

Module Code XISD5319 

Module Purpose The purpose of this module requires the students to integrate 

their acquired knowledge and skills to develop software 

applications that meet specific given business requirements 

for a given scenario. 

Module 

Outcomes 

Successful completion of this module requires students to: 

&#x20;

MO001: Identify software requirements for a new IT software 

system to meet given business requirements. 

MO002: Design the implementation plan to meet the pre

determined software requirements. 

MO003: Develop the deliverables identified in the 

implementation plan.  

MO004: Create comprehensive documentation for each 

required deliverable for the development and 

implementation of the new IT software system. 

MO005: Work together as a group to produce all deliverables 

of the new IT software system. 

&#x20;

Credits 15 

Notional Hours 150 

Type of WIL Project 

Tools and 

Resources 

Personal Computer 

Microsoft® Office 365 

GitHub 

Microsoft Visual Studio 2022 etc. 

Group/Individual 

Work 

Group (2 – 3 members) and individual  

Assessment 

Structure 

Assessment weightings 

&#x20;

Task 1 = 25%  

Task 2 = 50%  

Final Project Report = 25%   

&#x20;

&#x20; 

IIE Module Manual                                                                                                                                                                                                      

XISD5319/w 

6\. Pacer 

It is important to communicate with your lecturer on the progression of your project during the collaboration sessions to ensure you are 

progressing in the right direction. Your lecturer can offer guidance and recommendations to improve on your project. 

MILESTONE 

(ASSESSMENT POINT) 

TASK 

HAND IN 

WEEK 

Professional Conduct in the Workplace 

Programme (Annexure G) 

INDIVIDUAL 

Students must complete/read the Professional Conduct in the Workplace 

Programme (Annexure G) as part of the WIL module. No marks are allocated to 

this. 

Weekly class to discuss hurdles, 

issues and recommendations  

Two-hour collaborative sessions each week with the lecturer. Attendance is 

tracked by the lecturer for each of these sessions and should also be tracked by 

the team leader whether the group met in class or outside of class / online. 

© The Independent Institute of Education (Pty) Ltd 2026                                                               

Page 10 of 73 

IIE Module Manual                                                                                                                                                                                                                                  XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                               Page 11 of 73 

Task 1 (Weight 25%)   

Develop Project Plan  6 GROUP 

 Form groups of 2 – 3 members. Not more than three members per group. 

 Appoint roles such as project manager/team leader, software developer 

lead, secretary, software designer etc (Note: one person can have more 

than one role and contribute and help in other sections even if they are not 

“lead developer”). 

 Identify a small organisation  

 Analyse their business processes, system requirements, functions of the 

system, stakeholders, inputs, outputs and processing components of 

chosen organisation. 

 Project plan criteria are discussed and reviewed in the team. 

 Determine the scope of the new system you want to create along with 

milestones and deliverables. 

 Develop a work breakdown structure, risk analysis, and technical and 

economic feasibility. 

 Design a project plan using any tool you’d like example, MS Project. 

 Team to submit a project plan document on ARC in PDF format. 

 See more details below on requirements and layout of documentation. 

&#x20;

&#x20; 

IIE Module Manual                                                                                                                                                                                                                                  XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                               Page 12 of 73 

Task 2 (Weight 50%) 

Develop Requirement Analysis 

&#x20;

10 

&#x20;

GROUP 

Requirement Analysis Criteria 

 Determine functional requirements and develop use-case diagrams. 

 Develop a logical system model indicating inputs, outputs, processes and 

relationships. 

 Team to submit the requirement analysis document on ARC in PDF format. 

 See more details below on requirements and layout of documentation. 

Develop System Design GROUP 

System Design Criteria 

 Design the application architecture of the system using the different possible 

models. 

 Design the database. 

 Design the GUI and prototype of the applications. 

 Team to submit system design document on ARC in PDF format. 

 See more details below on requirements and layout of documentation. 

&#x20;

&#x20; 

IIE Module Manual                                                                                                                                                                                                                                  XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                               Page 13 of 73 

&#x20;

Project Report - Final Submission (Weight 25%) 

Report  Exam Week 2 GROUP 

 Merge the Project Plan, Requirement Analysis and System Design documents 

into ONE PDF document. 

 Must be a single submission – even though this is a group project, you are 

marked individually, and the submission points should be individual 

submissions. Each group member is to hand in individually. 

 In this individual submission, students should hand in their self and peer 

evaluations as well. Along with the group's PowerPoint presentation. (As 

stated below) 

 Any links used, such as GitHub or Figma, should be included in the document 

for the lecturer to access for marking. 

Presentation Exam Week 2 GROUP 

The group will present to the lecturers, peers, etc. 

 PowerPoint presentation of the WIL project. Include in the individual 

submission report. Other visual aids are welcome. 

 Demonstration of the applications. 

Self-Evaluation and Peer-Evaluation Exam Week 2 INDIVIDUAL 

Complete the peer and self-evaluation tasks. Include the documents in the 

individual submission report.  

&#x20;

IIE Module Manual                                                                                 

XISD5319/w                                    

7\. WIL Requirements 

See Annexure D for task rubrics.  

Task 1 – Project Plan 

 Introduction 

 Milestones and deliverables 

 Work breakdown structure  

 Project Schedules (Gantt Chart) 

 Risk Management 

 Technical Feasibility 

 Economic Feasibility 

 Team Members 

 Document Formatting  

 Appendix if applicable 

Task 2 – Requirement Analysis and System Design 

 Requirement Analysis - Problem Domain 

 Solution Domain (Active actors, functions, passive actors) 

 Logical System Model (Input specifications, output specifications, system 

processes\_ 

 Entity Relationship Tables 

 Class Diagrams 

 Appendix if applicable 

 System Design - Introduction 

 Logical Architectural Design (High-level design, low-level design) 

 User Interaction Design (Input interactions, request interactions) 

 Database Design (Database tables) 

 ERD Design 

 Report Design 

 Appendix if applicable 

© The Independent Institute of Education (Pty) Ltd 2026                                                          

Page 14 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

Project Report 

 Combine the above 3 documents into one. Everything must be in ONE 

document. This is an individual hand in on ARC.  

 See rubric below (Annexure D – Project Report). 

Submission should include:  

o Cover Page. 

o Table of Contents. 

o Group name and a list of the team members. 

o Any links to be included in the document, such as GitHub / Figma, 

etc. 

o Project plan documentation. 

o Requirement analysis documentation. 

o System design documentation. 

o Improvements should have been made to the above documentation 

based on lecturer's feedback for this final submission. 

o Any screenshots from the project, if necessary. 

o Annexures: 

1\. Declaration of Authenticity (Annexure A). 

2\. Peer evaluations (Annexure B). Penalties may be applied if the 

peer evaluations highlight an issue with a team member. 

3\. Self-evaluation reflective report (Annexure C). 

4\. Project Rubrics (Annexure D) 

5\. PowerPoint presentation (Annexures E and F) 

Project Presentation Criteria 

 Problem statement 

o How was the problem domain analysed and presented?  

 Business solution 

o Description of the system 

 Architecture 

o How was it solved? 

 How was the solution domain presented? 

 Milestones and deliverables? 

 Work breakdown structure? 

 Budgets? 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 15 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

o User requirements  

 Identification of business functionalities? 

 System Requirements Documentation 

o Value added? 

 How does it satisfy the needs of the client 

o Requirement Analysis documentation 

 Database 

o Scope (number of tables) 

o Table correctness (fields/datatypes, etc.) 

o Relationships (ERD) 

 System Prototype 

o Layout (aesthetics) 

o Friendliness 

o Menus/navigation 

o Functionality 

 Presentation skills mark 

o Introduction of the team 

o Eye-contact 

o Pace of presentation 

o Language (jargon) 

o Use of notes 

o Confidence 

o Dress 

o Layout of slides and information on slides (not too text-heavy) 

See rubric and mark allocations below (Annexure F). 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 16 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

8\. Detailed WIL Requirements 

8.1 

Task 1 

Project Plan Document 

Structure of the Document 

The layout of the document, including paragraphs, numbering, etc., must exactly match the 

specification below. Marks will be deducted for any deviations. 

Cover Page 

 Team number (if applicable) 

 Team name 

 Name and student number of each group member 

 Name of chosen client and logo of the system 

Index of Contents 

Should contain the numbering of each section and figures/tables if applicable. 

Documentation 

In your document submission, include sections as specified below. Include a cover page and 

an index/content. As specified in Section 7 of the WIL Requirements. If you have developed 

anything and stored it on an external site (e.g. GitHub) then you must provide a link in your 

document so the lecturer can access those files for marking. 

Introduction 

This paragraph is directed at the company's management for which the system is developed. 

Therefore, a summary of the justification for the system must be provided. Give attention to 

the following aspects: 

 The needs of the customer that the project should satisfy 

 The goals of the project 

 Cost constraints (budgets) 

 Risks (if the project is not successful, late, over budget, etc.) 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 17 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

 Benefits for the customer if the project is successful 

Milestones and deliverables 

Every project has milestones that represent important achievements in the development 

process. For example, when the system analysis is complete, a milestone has been reached. 

Each milestone is associated with a deliverable resulting from the activities that led to it. For 

the analysis milestone, the deliverable is the analysis document. Make a bullet list of the 

milestones and their associated deliverables. 

Work Breakdown Structure (WBS) 

Draw up a table containing: 

 The names of the tasks 

 Description of each task 

 Duration of each task  

 Predecessor(s) if each task 

 Team members responsible for each task 

 Resources needed for each task 

Project schedule 

Gantt Chart: 

 Draw a Gantt chart for your project using any tool you’d like (Example: MS 

Project / Team Gantt) 

 Interpret and explain the Gantt chart by describing the meanings of the different 

components of the chart for your project 

Risk Management 

Using a table: 

 Identify the risks to which your project may be exposed (e.g., team member leaves, no 

cooperation from sponsor/client, lack of technical expertise, team member does not 

contribute, running behind schedule, etc.) 

 Determine the probability of each risk as Very Low, Low, Medium, High, Very High and 

the impact as Very Low, Low, Medium, High, Very High 

 Indicate the proactive steps to be taken to handle each risk 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 18 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

Technical Feasibility Issues 

To develop a project, certain resources are needed; these can be grouped into hardware 

resources and software resources: 

 Make a list of the hardware resources you need to develop your project 

 Indicate if the hardware resources are available; if not, describe how you are going to 

solve the problem 

 Make a list of the software resources you need 

 Indicate if the software resources are available; if not, describe how you are going to 

solve the problem 

 Note: Do not refer to resources you need to implement the system 

Economic Feasibility Issues 

Project managers must make cost estimates if they want to complete projects within budget 

constraints. There are several ways in which the budget calculations can be done using Rough 

Order of Magnitude (ROM) calculation, budgetary estimate and definitive estimate.  

 Draw up a table indicating each activity/task (use the tasks identified in the WBS 

structure) 

 For each activity/task, state the team member(s) responsible for that task  

 For each team member, indicate the time allocated for that task in terms of hours 

 For each team member, indicate the tariff for that task in rand/hour 

 Calculate the total budget for the effort (remember, effort is person-time) for the project 

by adding all the effort values of all the team members. (Do not calculate any other 

budget costs, such as hardware or software costs) 

 Note: For converting sessions to hours, use the relationship: One session = 40 hours.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 19 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

Format of the table:  

Task  

Identification  

Team 

member(s) 

responsible  

Tariff per  

Time allocated 

per task per 

team member  

Cost per  

team member 

in Rand per 

hour  

Task Name  

::  

::  

Vusi 

::  

30 hours  

::  

150  

::  

Task   

(time \* tariff)  

4500  

::  

::  

Total budget for project    

::  

::  

::  

xxxxxxxx  

Team Members 

 Identify the team leader (use a photograph) 

 Identify the team members (use photographs) 

 Give a description of each team members main responsibilities in the project 

 Give a short CV of each team member (not longer than one page each) 

Appendix 

Enter any additional information needed here. This is optional.  

Do not forget any references: this includes a full reference list at the end of the document with 

matching in-text references throughout the document. 

Refer to the rubric for mark allocations (Annexure D – Task 1). 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 20 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

8.2 

Task 2  

Requirement Analysis Document  

Documentation 

In your document submission, include sections as specified below. Include a cover page and 

an index/content. If you have developed anything and stored it on an external site (e.g. GitHub) 

then you must provide a link in your document so the lecturer can access those files for 

marking. 

Introduction / Problem Domain (System Analysis) 

A study is made of the problem identified in the organisation selected. Use the introduction 

from the project plan document but give a more complete specification with more detail. 

Solution Domain (Functional requirements and UML Use Case Diagrams) 

A logical description of the functional requirements of the proposed system is given. You will 

use your UML background to draw a use case diagram of the system containing the following: 

 The business system, divided into sub-systems if necessary 

 The use cases actions 

 The actors taking part (this may be human actors or mechanical system actors such 

as linking to other systems) 

 The name of each entity (that is the system/sub-system use cases and actors in the 

diagram 

Format of the functional requirements table: 

Example:  

Participant  

(Active actor)  

Function of the system  

Participant  

(Passive actor)  

Customer  

Order groceries online  

Shop assistant  

Shop assistant  

Shops and delivers groceries  

Manager  

Customer  

Prepares a sales report    

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 21 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

Logical System Model 

The Logical system is modelled by completing the following table. It must be accurate, as it is 

the heart of the system.  

Format of the Logical System Model Table: 

Example:  

GUI   

System Process (Method)  

Input  

Output  

Register a new customer  

Entity relationship 

(Table)  

Enter 

customer 

details  

Customer table  

No input  

No output  

Calculate sales figures  

No input  

Sales table  

Sales report 

on printer  

Print sales report  

Sales table  

Class Diagrams 

Identify the classes using the entity relationship column in the above System Model Table. 

Each Entity Relationship Table represents an entity that could be a potential UML class.   

Format of Class Diagram Table:  

Name of entity (UML Class) Properties of entity (UML Class)  

Customer  

 

 

Name (string — 30 characters)  

Related to:  

Account   

Address (string — 60 characters)  

Once the tables are complete, you will need to draw a domain class diagram. Consider the 

following: 

 Draw diagrams indicating the relationships between the classes. Use a drawing tool 

such as Draw.io or any other tool to help prepare these diagrams. 

 The standard UML class template contains the name, attributes and operations of the 

class. However, for a domain class diagram, this will include the name, attributes and 

relationships only.  

 The following relationships between the classes need to be modelled if applicable: 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 22 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

o Associations 

o Generalisations 

o Aggregations 

o Any other dependencies between classes/sub-classes/objects 

Appendix 

Use this paragraph to add any information not specified in the previous paragraphs, but is 

worthwhile including in the document. Number each appendix: Appendix A, Appendix B, etc. 

Also, add an index of Appendices. You need to make sure all diagrams are visible and legible, 

consider adding smaller sections as appendices.  

Do not forget any references: this includes a full reference list at the end of the document with 

matching in-text references throughout the document. 

Refer to the rubric below for mark allocations (Annexure D – Task 2). 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 23 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

System Design Document 

Documentation 

In your document submission, include sections as specified below. Include a cover page and 

an index/content. As specified in Section 7 of the WIL Requirements.  

Introduction  

Provide a description of your system (use information from previous documents) 

Logical Architectural Design – High-Level Architectural Design 

 Indicate whether it is a three-level, two-level or flat system, the clients and the servers, 

the position of the database, etc. 

 Indicate how the functional building blocks are divided between the components of the 

system (functions allocated to the clients, the server, etc.) 

 Refer to the previous document and the system model table for details on the system 

Input/Output specification 

 Also refer to the previous document for the functional requirements table for the system 

Logical Architectural Design – Low-Level Architectural Design 

In the low-level design, the relationships between actors, functions and the database tables 

are indicated. 

A low-level design is indicated in the following diagram: 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 24 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

The low-level design diagram consists of three parts: 

 Actors: The actors refer to the actors identified in the previous document in the use

case diagrams  

 Functions: The functionality of the system is modelled using use cases. State the 

function of each use case briefly. Arrows indicate any relationships between use cases 

 Database: The database or table referred to in a use case must be indicated using a 

circle. The meaning of a database must be indicated using a note comment or a label  

Interactions with the User – Input Interactions 

These interactions represent data controls used to read data into the system. This is the first 

reference to the GUI containing the complete interaction specification. In this document, the 

input interactions must be specified in detail.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 25 of 73 

IIE Module Manual                                                                                                                       XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                        Page 26 of 73 

There are two options you can follow:  

Option 1: Give a summary of the input options.  

Make a structured annotated list of all your inputs. The list must indicate the hierarchical 

relationship between the input menus.  

&#x20;

For example: 

Main Menu Main Menu Item #1 Main Menu Item #2 

1st Level 1.1 Sub Menu 1 2.1 Sub Menu 2 

&#x20;1.2 Sub Menu 2 2.2 Sub Menu 2 

&#x20;xxx xxx 

2nd Level 1.1.1 Sub-sub-Menu 1 2.1.1 Sub-sub-Menu 2 

&#x20;Etc. Etc. 

&#x20;

Example: You want to register a student at your college: 

Menu Level Student Personal 

Info 

Student Study Financial 

1st Level Biographical Year of Study Financial 

2nd Level Name Degree Bank act 

2nd Level  Age Subjects Saving act 

1st Level Address Subject #1  

2nd Level Street Subject #2  

2nd Level Post Box Subject #3  

1st Level Contact    

2nd Level Telephone   

2nd Level Cell Phone   

&#x20;

Option 2: Give a complete GUI definition.  

Use C# or Java (or a similar visual tool like Figma) and design a complete GUI of all the input 

interactions. Include this design in your document.  

&#x20; 

Note: The input menus and forms play an important role in the identification of the attributes 

and services of the classes.  

&#x20; 

IIE Module Manual                                                                                                                       

XISD5319/w 

Interactions with the User – Requests Interactions 

These interactions represent all service requests put to the system and include requests for 

functional processing (scheduling, calculating statistics, etc.) and outputs in the form of screen 

displays (graphical representations) and printed reports. Request interactions refer to menus 

and output parameter forms used to specify the services (value-added) provided by the 

system.  

Again, you have two options:  

Option 1: Give a summary of the interactions.  

Make a complete hierarchical list of all the interactions, as explained in the Input section.  

Option 2: Give a complete GUI definition.  

Specify the interactions by designing the GUI (menus and forms) using a visual tool (Visual 

Studio, Figma, or another similar tool) and include them in your document. 

Note: In this document, non-functional aspects such as creating a file, defining passwords, 

and handling error messages are not covered. If you did not account for all interactions in your 

analysis document, you must now ensure that any interactions that were not considered are 

included in the design document. In your document, you must include paragraphs that 

describe the interactions.  

Database Design 

Refer to your class diagram table to indicate entities and their relationships. 

 Use these entities as building blocks in the design of your ERD data model 

 Complete the following steps in designing your model 

o Identify all the entities in your database. This is possible by consulting your 

tables and the input and output menus of your GUI. Identify all the relationships 

between the entities and normalise them into 3NF 

o Use any tool (e.g., MS Word) to draw the ERD logical database tables 

 As part of the relationship design, the keys related to each database table must be 

identified and specified. There are primary keys, secondary keys, foreign keys, 

composite keys, etc. 

 The following database table layout can be used: 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 27 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

Table Name: <insert table name>  

Primary 

key  

Secondary keys  

Data fields     

Secondary 

key #1  

Secondary 

key #2  

Field 

\#1  

Field 

\#2  

Field 

\#3  

……….  Field 

\#n  

Note: that the properties of an entity in the Class Diagram become the data fields of the 

database table.  

 Draw a set of database tables (see below) 

 Draw the relationship diagrams between the tables (see below) 

Draw diagrams of the individual table’s design, using the following numbering scheme:  

Database Table#1: <Insert Table #1 here>  

Primary 

key  

Secondary keys  

Data fields     

Secondary 

key #1  

Secondary 

key #2  

Field 

\#1  

Field 

\#2  

Field 

\#3  

……….  Field 

\#n  

Database Table#2: <Insert Table#2 here>  

Primary 

key  

Secondary keys  

Data fields     

Secondary 

key #1  

Secondary 

key #2  

Field 

\#1  

Field 

\#2  

Field 

\#3  

……….  Field 

\#n  

And so on...  

In each table, at least three fictitious, although realistic, values must be entered to serve as 

examples. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 28 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

Entity Relationship Database Design 

Draw diagrams of the relationships between the tables using ERD diagrams. Number each 

table according to the following scheme:  

ERD diagram #1: <Insert ERD diagram here>  

ERD diagram #2: <Insert ERD diagram here> 

You may use any tool you’d like to draw these, such as Draw.io. 

System Reports Design 

As part of your database and ERD design, consider the reports your system must generate 

for the client. Identify what reports are needed, the data sources from your tables, and how 

the system will present these reports (screen display, printed, or PDF, etc.) Ensure that the 

design supports accurate and usable outputs. 

Appendix 

Appendices are optional. It contains additional information important for the system. Number 

each appendix: Appendix A, Appendix B, etc. 

Do not forget any references: include a full reference list at the end of the document, with 

matching in-text references throughout. 

Refer to the rubric below for mark allocations (Annexure D – Task 2). 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 29 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

8.3 

Project Report  

Final Hand In 

Documentation 

In your document submission, include sections as specified below. Include a cover page and 

an index/content. As specified in Section 7 of the WIL Requirements. If you have developed 

anything and stored it on an external site (e.g. GitHub) then you must provide a link in your 

documents so the lecturer can access those files for marking. 

Combine All Previous Documents into ONE PDF Document 

Your project plan, requirement analysis, and system design documents need to be combined 

into a single document for this final submission.  

Project Plan Document 

Based on your lecturer's feedback on your project plan document – Task 1 – make the 

necessary changes/improvements.  

At the end of the project plan content, add a new sub-heading: “Changes Made to Project Plan 

Based on Lecturer Feedback”. And detail all changes made to the project plan document. 

Requirement Analysis Document 

Based on feedback from your lecturer on your requirement analysis document – Task 2 – 

make the necessary changes/improvements.  

At the end of the requirement analysis content, add a new sub-heading: “Changes Made to 

Requirement Analysis Based on Lecturer Feedback”. And detail all changes made to the 

requirement analysis document. 

System Design Document 

Based on your lecturer's feedback on your system design document – Task 2 – make the 

necessary changes/improvements.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 30 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

At the end of the system design content, add a new sub-heading: “Changes Made to System 

Design Based on Lecturer Feedback”. And detail all changes made to the system design 

document. 

The final submission must also include a fully developed system prototype. At least it must be 

done in Figma, you could also do this in an IDE, which may benefit you for next semester. If 

this is done in an IDE, it must be connected to GitHub and the link provided in this final 

submission.   

The prototype must reflect the system design, support user interactions, and demonstrate 

system functionality, including navigation, inputs, requests, and reports. No coding is required 

at this stage; only the design for each page is required. Screenshots of the prototype must be 

included in the document, along with a working link to the Figma and/or GitHub repository. 

Appendix 

This is an individual submission. You will need to submit your ONE document containing all 

the above, ensuring any links (e.g., GitHub, Figma) have been added. Any screenshots if 

necessary. Annexure A, Annexure B, Annexure C and the PowerPoint presentation has been 

submitted. Do not forget references. Refer to the rubric below for mark allocations 

(Annexure D – Project Report). 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 31 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

9\. WIL Mark Breakdown 

MILESTONE 

(ASSESSMENT 

POINT) 

SUBMISSION POINTS 

WEIGHT 

MARK 

BREAKDOWN 

Task 1 

1\. Project Plan  

25% 

Task 2 

100 

1\. Requirement Analysis 

2\. System Design 

100 

50% 

100 

Project Report 

(Final 

Submission) 

1\. A combination of the above 

documents into one document, 

with changes made from the 

lecturer's feedback.  

2\. Any links, screenshots and 

PowerPoint presentation needs 

to be submitted. 

100 

25% 

3\. Annexures  

 Peer-Evaluations (30 

marks) 

 Self-Evaluation (50 

marks) 

 Presentation rubric (20 

marks) 

100 

4\. Presentation to lecturer, peers 

and possible clients. 

100 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 32 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

ANNEXURE A – Declaration of Authenticity 

Plagiarism occurs in various forms. Ultimately, though, it refers to the use of another person's 

words, ideas, or images without acknowledging the source and using the required 

conventions. The IIE publishes a Quick Reference Guide (available on The IIE Library website) 

that provides more detailed guidance, but a brief description of plagiarism and referencing is 

included below for your reference. It is vital that you are familiar with this information and the 

Intellectual Integrity Policy before attempting any assignments. 

The IIE respects the intellectual property of other people and requires its students to be familiar 

with the necessary referencing conventions. Please ensure that you seek assistance in this 

regard before submitting work if you are uncertain. 

If you fail to acknowledge the work or ideas of others or do so inadequately this will be handled 

in terms of the Intellectual Integrity Policy (IIE023 – \[available in the library]) and/or the Student 

Code of Conduct policy (IIE026)– depending on whether or not plagiarism and/or cheating 

(passing off the work of other people as your own by copying the work of other students or 

copying off the Internet or from another source) is suspected. 

Your campus offers individual and group training on referencing conventions – please speak 

to your librarian or ADC/Campus co-ordinator in this regard. 

Reiteration of the Declaration you have signed: 

1\. 

I have been informed about the seriousness of acts of plagiarism. 

2\. 

3\. 

4\. 

5\. 

6\. 

7\. 

I understand what plagiarism is. 

I am aware that The Independent Institute of Education (IIE) has a policy regarding 

plagiarism and that it does not accept acts of plagiarism. 

I am aware that the Intellectual Integrity Policy and the Student Code of Conduct 

prescribe the consequences of plagiarism. 

I am aware that referencing guides are available in my student handbook or equivalent 

and in the library, and that following them is a requirement for successful completion of 

my programme. 

I am aware that should I require support or assistance in using referencing guides to 

avoid plagiarism, I may speak to the lecturers, the librarian, or the campus ADC/ Campus 

Co-ordinator for clarification. 

I am aware of the consequences of plagiarism. 

Please ask for assistance prior to submitting work if you are at all unsure. 

\*\*Attach the declaration to your report  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 33 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

Declaration of authenticity

I, \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_ ID Number, \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_ hereby 

declare that this portfolio, and any evidence included therein, contains my own 

independent work and that I have not received help from other groups. 

I confirm that we have not committed plagiarism in the accomplishment of this work, 

nor have I falsified and/or invented experimental data. 

I accept the academic penalties that may be imposed for violations of the above. 

STUDENT NUMBER: \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_               

STUDENT NAME: \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_ 

STUDENT SIGNATURE: \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_        

DATE: \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_ 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 34 of 73 

IIE Module Manual                                                                                                                       

XISD5319/w 

ANNEXURE B - Peer Evaluation  

(NOT TO BE SHARED WITH TEAM MEMBERS) 

\*\*Please complete and include the peer-evaluation reports when submitting your final PoE.  

GROUP NAME/NUMBER: ……………………………. 

DATE: ………………………….. 

Please rate each of your team members using the details in the assessment criteria descriptions 

provided. Marks received from each member of the team will be added up and then averaged for each 

member’s individual mark. Complete a separate evaluation form for each team member. 

Name of student being evaluated: 

Never 

Seldom 

0 

Frequently 

Always 

The student’s personal work     

1 

1\. 

2 

3 

The student contributed good ideas that added value to 

the project. 

2\. 

The student performed their tasks in line with what was 

expected of them. 

3\. 

4\. 

The student produced high quality work.     

The student managed their own time well and met 

deadlines. 

5\. 

The student connected their own learning and skills to a 

real-world problem. 

The student’s work as part of a team (when relevant)     

6\. 

The student accepted responsibility for a fair portion of 

the tasks. 

7\. 

The student was an enthusiastic member of my team.     

The student helped others to be successful.     

8\. 

9\. 

10\. 

The student worked well with other members of the team.     

The student showcased respect and dignity towards all 

members of the team. 

TOTAL:                                                                                                                          

/30 

Comments: 

…………………………………………………………………………………………………..………

………………………….………………………………………………………………………………

…………………………………………………………………………………………………………… 

NAME: …………………………………………. STUDENT NUMBER: …………………………. 

SIGNATURE: ………………………………….  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 35 of 73 

IIE Module Manual                                                                                                                       XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                        Page 36 of 73 

ANNEXURE C - Self-Reflective Report 

&#x20;

\*\*Please complete and include this self-reflective report when submitting your final PoE.  

&#x20;

Using the reporting structure below, write a self-reflection report on your experience 

explaining how and what you learnt doing the WIL: 

&#x20;

Introduction 

&#x20;

Write an introductory paragraph in which you briefly outline your understanding of the 

purpose and value of WIL. 

&#x20;

Skills Learnt  

&#x20;

Identify the skills you have learnt. State how you used/were expected to use each skill during 

your WIL. Consider skills under each of the following three categories and report on each:  

&#x20;

 Industry specific practices, e.g. report writing, planning skills, compilation of 

charts/graphs etc. 

 Interpersonal communication skills, e.g. brainstorming sessions, feedback sessions, 

staff meetings or briefing and debriefing sessions, etc. 

 Management skills, e.g. time management to meet deadlines, crisis management to 

solve unexpected problems, etc. 

&#x20;

Role in the team  

&#x20;

Describe the team dynamic during your WIL and whom you reported to and with whom you 

were in a team with. Comment on your role in the team with regard to all of the following 

points:  

Leadership responsibilities and being provided instruction. 

&#x20;

 Your contribution to team success. 

 The group dynamic and your contribution to the group/team. 

 Dealing with concerns, complaints, queries and conflict. 

&#x20;

Research, technology and the presentation of information 

&#x20;

Finding information that is both relevant and useful is a much-needed skill in WIL.  

&#x20;

 Describe one (1) or two (2) scenarios in which you were expected to find information 

for a task or duty that you had to complete. This can be related to online research, 

finding client or supplier contact information, or looking through files and databases 

to find relevant data.  

 Where did you find the information you needed to do this work?  

 What technology did you use?  

 How did you have to present the information you found?  

IIE Module Manual                                                                                                                       XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                        Page 37 of 73 

&#x20;

Personal strengths (strong points) and weaknesses (areas to do better in)  

&#x20;

Comment on the elements, tasks or duties during your WIL that you found yourself excel in, 

as well as the ones you found difficult to master.  

&#x20;

 List and describe the tasks that you did really well in.  

 Identify at least five strengths that you realised you have.  

 List and describe the tasks that you did not do well in.  

 Why in your opinion, did you not perform well in these tasks?  

 Comment on how you think you can improve on the weaknesses that you identified. 

&#x20;

Stakeholder relationship 

&#x20;

Describe your relationship with the lecturer or in the case of placement, the mentor in the 

workplace by focusing on the following areas:  

&#x20;

 Part of this relationship that worked well for you and parts that did not. 

 Explain how you think you could have made the relationship better or stronger. 

&#x20;

Impact 

&#x20;

This refers to your contributions to the project/ organisation during your placement there.  

&#x20;

 Comment on how you think others (if placed, management, fellow staff members, 

team members, clients, suppliers and others you worked with during your 

placement) benefitted from you being there and the work you did.  

 Describe how you have made a better/greater/more positive impact. 

&#x20;

Conclusion 

&#x20;

Write a summary whereby a clear overall impression of your WIL experience is provided. 

&#x20;

&#x20;

The lecturer will use the rubric below to mark your self-reflection report. Consider the criteria 

in the rubric when compiling your report.  

IIE Module Manual                                                                                                                                                                                                    XISD5319/w                                     

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                       Page 38 of 73 

&#x20;

SELF-EVALUATION RUBRIC 

&#x20;

REFLECTION REPORT CRITERIA 0-1 Does not meet the 

required standard 

&#x20;

2-4 Meets the 

required standard 

5- Exceeds the required 

standard 

Mark 

Introduction (CCFO8) 

&#x20;

Write an introductory paragraph in which you briefly outline your 

understanding of the purpose and value of WIL 

&#x20;

&#x20;

 Lack of 

understanding of the 

purpose and value of 

WIL. 

 Did not refer to 

preparation for the 

world of work. 

 Did not mention 

concepts from any 

modules. 

 Some 

understanding of 

the purpose and 

value of WIL. 

 Could relate to the 

world of work but 

did not mention 

concepts from 

modules. 

 Clear understanding of 

the purpose and value 

of WIL. 

 Explained the 

relationship between 

the world of work and 

the concepts from a 

range of modules.  

&#x20;

&#x20;

&#x20;0-1 Does not meet the 

required standard 

2- Meets the required 

standard 

3-4 Partially exceeds 

the required 

standard 

5- Greatly exceeds the 

required standard 

Mark 

Skills Learnt (CCFO1; CCFO2; CCFO3; 

CCFO4; CCFO8) 

&#x20;

Identify the skills you have learnt. State how 

you used/were expected to use each skill 

during your WIL. 

&#x20;

 The student did not 

reflect on the skills 

they learnt. 

 Limited to no details 

or examples were 

provided.   

&#x20;

 The student thought 

about some skills that 

they learnt during the 

WIL.  

 Some examples were 

provided as per brief 

&#x20;

 The student clearly 

considered and 

reflected some 

understanding of 

the skills they learnt. 

 Detailed examples 

were provided, 

however there was 

no or limited 

reflection on the 

skills learnt. 

&#x20;

 The student fully 

understands and can 

explain to others what 

skills they learnt in the 

WIL module.  

 Detailed examples for 

what and how the 

student learnt were 

provided. 

 Reflection on the skills 

learnt is complete and 

done well in line with 

the brief.  

&#x20;

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 39 of 73                                                                                     

&#x20;0-1 Does not meet the 

required standard 

2- Meets the required 

standard 

3-4 Partially exceeds 

the required 

standard 

5- Greatly exceeds the 

required standard 

Mark 

Role in the team (CCFO2; CCFO8) 

&#x20;

Describe the team dynamic during your WIL. 

Who you reported to and who you were on a 

team with. Comment on your role in the 

team.  

 The student did not 

clearly reflect on the 

team dynamic.  

 The role of the 

student concerning 

their role in the team 

is not clear. 

 The student reflected 

on the team dynamic 

and some key issues 

concerning their role 

in the team were 

described. 

 The student clearly 

reflected on the 

team dynamic and 

underlined all key 

issues.  

 The student 

reflected on how 

they contributed to 

team success. 

 The team dynamic is 

clearly described.  

 The role of the student 

concerning their role in 

the team is clear and in 

line with the brief.  

 The student reflected 

on their contribution to 

the team success and 

how they addressed 

concerns and/or 

complaints.  

&#x20;

&#x20;

&#x20;0-4 Does not meet the 

required standard 

5-6 Meets the required 

standard 

7-9 Partially exceeds 

the required standard 

10- Greatly exceeds the 

required standard 

Mark 

Research, technology and the 

presentation of information (CCFO5; 

CCFO6; CCFO8) 

&#x20;

Finding information that is both relevant and 

useful is a much-needed skill in WIL. 

 Describe one or two scenarios in 

which you were expected to find 

information for a task or duty that you 

had to complete. This can be related 

to online research, finding client or 

supplier contact information, or 

looking through files and databases 

to find relevant data.  

 Where did you find the information, 

you needed to do this work?  

 What technology did you use?  

 How did you have to present the 

information you found? 

 The student did not 

clearly reflect on 

research, technology 

and the presentation 

of information. 

 The student reflected 

on a limited number 

of key issues 

concerning research, 

technology and the 

presentation of 

information. 

 The student 

attempted to share 

how the information 

was found, used and 

presented. 

 The student clearly 

reflected on the key 

issues concerning 

research, 

technology and 

presentation of 

information.  

 The student clearly 

addressed how and 

where information 

was found and what 

technology was 

used. 

 Most aspects relating 

to research, 

technology and the 

presentation of 

information is clearly 

described as per brief.  

 The student presented 

clear scenarios that 

they had to complete. 

 The student clearly 

described where the 

information was found 

and what technology 

was used.  

&#x20;

&#x20;

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 40 of 73                                                                                     

&#x20;0-4 Does not meet the 

required standard 

5-6 Meets the 

required standard 

7-9 Partially exceeds 

the required 

standard 

10- Greatly exceeds 

the required standard 

Mark 

Personal strengths (strong points) and 

weaknesses (areas to do better in) 

(CCFO8) 

&#x20;

Comment on the elements, tasks or duties 

during your WIL that you found yourself 

excel in, as well as the ones you found 

difficult to master.  

&#x20;

 List and describe the tasks that you 

did well in.  

 Identify at least five strengths that 

you realised you have.  

 List and describe the tasks that you 

did not do well in.  

 Why in your opinion, did you not 

perform well in these tasks?  

 Comment on how you think you can 

improve on the weaknesses that you 

identified. 

 The student did not 

accurately reflect on 

their personal 

strengths and 

weaknesses.  

&#x20;

 Limited to no details 

were provided as per 

the brief, and the 

reflection lacks 

insight on how 

weaknesses can be 

improved. 

 The student 

displayed some 

understanding of their 

personal strengths 

and weaknesses.  

&#x20;

 Some details were 

provided as per the 

brief, and the 

reflection included a 

satisfactory 

description of how 

weaknesses can be 

improved. 

 The student 

displayed a good 

understanding of 

their personal 

strengths and 

weaknesses. 

&#x20;

 Most of the details 

were provided as 

per the brief, and 

the reflection 

included a more 

than satisfactory 

description of how 

weaknesses can be 

improved.  

 The student fully 

recognises their 

personal strengths and 

weaknesses.  

&#x20;

 Details and examples 

were provided as per 

the brief, and the 

student clearly 

understands how to 

improve on their 

weaknesses. 

&#x20;

&#x20;

&#x20;0-2 Does not meet the 

required standard 

3- Meets the required 

standard 

4- Partially exceeds 

the required 

standard 

5- Greatly exceeds the 

required standard 

Mark 

Lecturer relationship (CCFO2; CCFO8) 

&#x20; 

 Describe your relationship with the 

lecturer or, in the case of placement, 

the mentor in the workplace by focusing 

on the following areas:  

 Part of this relationship that worked well 

for you and parts that did not. 

 The student did not 

adequately describe 

their relationship with 

the lecturer and/or 

mentor.  

 Limited to no 

understanding was 

shown on how the 

quality of the 

 The student 

displayed satisfactory 

understanding of their 

relationship with the 

lecturer and/or 

mentor.  

 The student provided 

some details on how 

the relationship could 

have been improved. 

 The student 

displayed a more 

than satisfactory 

understanding of 

the relationship with 

the lecturer and/or 

mentor.  

 Details were 

provided on which 

part of the 

 The student fully 

understands their 

relationship with the 

lecturer and/or mentor.  

 Details were provided 

on which part of the 

relationship worked 

well and which parts 

did not.  

&#x20;

&#x20;

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 41 of 73                                                                                     

 Explain how you think you could have 

made the relationship better or 

stronger. 

relationship could 

have been enhanced. 

relationship worked 

well and which parts 

did not.  

 The student 

provided clear 

details on how the 

relationship could 

have been 

improved.  

 The student is also 

able to 

comprehensively 

explain how the 

relationship could have 

been made stronger or 

better.  

 Overall, the reflection 

on the stakeholder 

relationship is 

complete and done 

well in line with the 

brief. 

&#x20;0-1 Does not meet the 

required standard 

2-3 Meets the 

required standard 

&#x20;4 -5- Meets or exceeds 

the required standard 

Mark 

Impact (CCFO8) 

&#x20;

This refers to the impact the project could 

have on the organisation/scenario.  

&#x20;

 Describe how you have made a 

better/greater/more positive impact.  

 The student did not 

think about their 

contributions during 

WIL and how it would 

have had an impact 

on the final project.  

 The student provided 

limited insight into 

their contributions 

during WIL and how it 

would have had an 

impact on the final 

project 

&#x20; The student’s reflection 

on their contribution 

during WIL is complete 

and done well in line 

with the brief. 

 It was well evidenced 

how the student made 

a positive impact to the 

organisation.  

&#x20;

&#x20;

&#x20;

&#x20;0-2 Does not meet the 

required standard 

3-4 Meets the 

required standard 

5- Exceeds the 

required standard 

Mark 

Conclusion (CCFO4; CCFO8) 

&#x20;

Write a summary whereby a clear overall impression of your WIL 

experience is provided. 

 The student did not 

provide a clear 

summary of their 

overall impression of 

their WIL experience 

 The student 

provided an 

adequate summary 

of their overall 

impression of their 

WIL experience. 

More details could 

have been included 

in this regard. 

 The student provided a 

clear and detailed 

summary of their 

overall impression of 

their WIL experience. 

&#x20;

&#x20;

TOTAL /50 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 42 of 73                                                                                     

ANNEXURE D - Project Rubric 

&#x20;

&#x20;

&#x20;

Assessment Sheet (Marking Rubric) – Task 1 

&#x20;

MODULE NAME: MODULE CODE: 

WIL – Work Integrated Learning 3A XISD5319 

&#x20;

GROUP MEMBERS 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

&#x20;

TASK 1 PROJECT PLAN 

Marking 

Criteria 

Does not meet the 

required standard 

Meets the required 

standard 

&#x20;Partially exceeds 

the required 

standard 

&#x20;

Greatly exceeds the 

required standard 

&#x20;

Feedback 

Introduction  

&#x20;

\[5 Marks] 

Introduction missing or 

poorly justified; 

customer needs, 

goals, budgets, risks, 

Introduction addresses 

some aspects, but may 

omit one or two; 

justification is weak 

Introduction 

addresses most 

aspects; some 

justification is clear 

Introduction fully 

addresses all aspects: 

customer needs, 

goals, budgets, risks, 

and benefits; 

&#x20;

Include this RUBRIC with your submission as part of the ONE document.  

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 43 of 73                                                                                     

or benefits not 

mentioned 

and linked to 

customer needs 

justification is clear 

and professional 

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

&#x20;Milestones 

and 

Deliverables 

&#x20;

\[5 Marks]  

Milestones missing or 

unclear; deliverables 

not identified 

Some milestones and 

deliverables are 

identified; not clearly 

linked 

Most milestones and 

deliverables clearly 

identified; some links 

may be unclear 

All milestones and 

associated 

deliverables clearly 

and logically 

presented 

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

&#x20;

Work 

Breakdown 

Structure 

&#x20;

\[10 Marks] 

Tasks not identified or 

described; missing 

duration, 

predecessors, team 

members, or 

resources 

Some tasks identified; 

incomplete descriptions; 

missing elements 

Most tasks identified 

and described; minor 

omissions 

All tasks clearly 

identified with 

description, duration, 

predecessors, 

responsible team 

members, and 

resources 

&#x20;

0 - 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

Gantt Chart 

and 

Interpretation 

&#x20;

\[10 Marks] 

Gantt chart missing or 

incorrect; no 

interpretation 

Gantt chart partially 

correct; interpretation 

limited 

Gantt chart mostly 

correct; interpretation 

shows understanding 

Gantt chart fully 

correct; interpretation 

clear, accurate, and 

insightful 

&#x20;

0 - 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

Risk 

Management 

&#x20;

\[20 Marks] 

Risks not identified; 

probability/impact not 

assessed; no 

mitigation 

Some risks identified; 

probability/impact 

assessed but 

incomplete; mitigation 

plans weak 

2 or less risks 

identified; 

probability/impact 

mostly assessed; 

mitigation plans 

mostly appropriate 

4 or more risks 

identified; probability 

and impact accurately 

assessed; proactive 

mitigation plans 

clearly outlined 

&#x20;

0 - 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 44 of 73                                                                                     

Technical 

Feasibility 

&#x20;

\[15 Marks] 

Hardware/software 

resources not 

identified; availability 

issues not addressed 

Some resources listed; 

availability or mitigation 

partially addressed 

Most resources listed; 

availability and 

mitigation mostly 

addressed 

All required 

hardware/software 

resources identified; 

availability issues and 

solutions fully 

explained 

&#x20;

0 - 5 Marks 6 - 8 Marks 9 - 12 Marks 13 - 15 Marks  

Economic 

Feasibility 

&#x20;

\[15 Marks] 

Activities, 

responsibilities, time, 

tariff, or cost 

calculations missing 

or incorrect 

Some activities or cost 

calculations included, 

incomplete or partially 

correct 

Most activities and 

cost calculations 

included - minor 

errors 

All activities identified; 

time, tariff, and total 

cost calculations 

correct and clearly 

presented 

&#x20;

0 - 5 Marks 6 - 8 Marks 9 - 12 Marks 13 - 15 Marks  

Team Members 

&#x20;

\[5 Marks] 

Team 

leader/members not 

identified; roles 

unclear; CVs missing 

Some team members 

identified; roles or CVs 

incomplete 

Most team members 

identified; roles and 

CVs mostly complete 

All team members 

identified; roles clearly 

described; CVs 

concise and complete 

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

Document 

Format and 

Layout 

&#x20;

\[15 Marks] 

Layout, formatting, 

numbering, 

tables/figures, or 

clarity missing 

Some formatting and 

layout elements correct; 

but inconsistent 

Most formatting 

elements correct; 

minor inconsistencies 

Document fully 

formatted, numbered, 

clear, tables/figures 

correctly labelled if 

applicable; 

professional 

appearance and use 

of colour 

&#x20;

0 - 5 Marks 6 - 8 Marks 9 - 12 Marks 13 - 15 Marks  

TOTAL /100 

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 45 of 73                                                                                     

Assessment Sheet (Marking Rubric) – Task 2 Requirement Analysis 

&#x20;

&#x20;

&#x20;

&#x20;

MODULE NAME: MODULE CODE: 

WIL – Work Integrated Learning 3A XISD5319 

&#x20;

GROUP MEMBERS 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

&#x20;

TASK 2 REQUIREMENT ANALYSIS 

Marking 

Criteria 

Does not meet the 

required standard 

Meets the required 

standard 

&#x20;Partially exceeds 

the required 

standard 

&#x20;

Greatly exceeds the 

required standard 

&#x20;

Feedback 

Introduction / 

Problem 

Domain 

&#x20;

\[5 Marks] 

Missing or very weak; 

lacks detail on 

problem, context, or 

organisation 

Addresses problem 

domain; some detail 

missing 

Mostly detailed; 

problem, context, and 

organisation mostly 

clear 

Complete and 

detailed; problem, 

context, and 

organisation fully 

explained 

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

&#x20; 

Include this RUBRIC with your submission as part of the ONE document.  

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 46 of 73                                                                                     

Solution 

Domain – Use 

Case \& 

Functional 

Requirements 

&#x20;

\[20 Marks]  

Use cases missing or 

incorrect; actors and 

functions unclear 

(active (5), passive 

actors (5) not 

identified, no functions 

(10)) 

&#x20;

Some actors and 

functions correctly 

identified; partial use 

case diagram 

Most actors and 

functions identified; 

use case diagram 

mostly correct 

All actors and 

functions clearly 

identified; use case 

diagram complete, 

accurate, and logically 

structured 

&#x20;

0 - 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

&#x20;

Logical System 

Model 

&#x20;

\[20 Marks] 

Input/output, system 

processes, or entity 

tables missing or 

incorrect 

Some elements correctly 

included 

Most elements correct All elements accurate: 

input/output, 

processes, entity 

tables complete 

&#x20;

&#x20;

0 - 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

Class 

Diagrams 

&#x20;

\[50 Marks] 

Less than 5 classes; 

class names wrong or 

not accurate, 

properties / attributes 

missing or none and 

relationships missing 

or none 

&#x20;

Minimum 5 classes with 

partial properties / 

attributes or 

relationships, a few 

errors  

Classes mostly 

complete; minor 

errors 

All classes fully 

described with 

properties / attributes 

and relationships; 

UML diagram clear 

&#x20;

0 - 19 Marks 20 - 29 Marks 30 - 39 Marks 40 - 50 Marks  

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             

XISD5319/w 

Document 

Formatting / 

Layout 

\[5 Marks] 

Layout, formatting, 

numbering, 

tables/figures, or 

clarity missing  

Some formatting and 

layout elements correct; 

but inconsistent 

Most formatting 

elements correct; 

minor inconsistencies 

Document fully 

formatted, numbered, 

clear, tables/figures 

correctly labelled if 

applicable; 

professional 

appearance and use 

of colour 

0 - 1 Marks 

2 - 3 Marks 

4 Marks 

5 Marks 

TOTAL 

/100 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     

Page 47 of 73                                                                                     

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 48 of 73                                                                                     

&#x20;

Assessment Sheet (Marking Rubric) – Task 2 System Design 

&#x20;

&#x20;

&#x20;

MODULE NAME: MODULE CODE: 

WIL – Work Integrated Learning 3A XISD5319 

&#x20;

GROUP MEMBERS 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

&#x20;

TASK 2 SYSTEM DESIGN 

Marking 

Criteria 

Does not meet the 

required standard 

Meets the required 

standard 

&#x20;Partially exceeds 

the required 

standard 

&#x20;

Greatly exceeds the 

required standard 

&#x20;

Feedback 

Introduction 

&#x20;

\[5 Marks] 

Missing or very weak; 

unclear system 

overview 

Overview present; some 

detail missing 

Mostly complete; 

system overview 

mostly clear 

&#x20;

Complete and 

detailed system 

overview 

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

&#x20; 

Include this RUBRIC with your submission as part of the ONE document.  

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 49 of 73                                                                                     

Logical 

Architectural 

Design  

&#x20;

\[10 Marks]  

High/low-level design 

missing or incorrect (5 

marks each)  

&#x20;

High or low-level design 

partially correct 

Most design elements 

correct 

High and low-level 

design fully correct; 

client/server, 

database, and 

functional 

components clear 

&#x20;

&#x20;

0 - 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

&#x20;

User 

Interaction 

Design – Input 

Interactions 

&#x20;

\[20 Marks] 

Input interactions 

missing or unclear 

Some interactions 

described; partially 

correct 

Most interactions 

described; minor 

errors 

All interactions fully 

described and 

correctly structured; 

diagrams/menus clear 

&#x20;

&#x20;

0 - 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

User 

Interaction 

Design – 

Request 

Interactions 

&#x20;

\[10 Marks] 

Request interactions 

missing or unclear  

Some interactions 

described; partially 

correct 

Most interactions 

described; minor 

errors 

All request 

interactions complete; 

diagrams/screens 

consistent 

&#x20;

&#x20;

0 - 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

Database 

Design – 

Database 

Tables 

&#x20;

\[20 Marks] 

Tables missing or 

incomplete 

Some tables correct; 

incomplete fields 

Most tables correct; 

minor omissions 

All tables complete; 

fields, keys, etc. 

(Minimum 4 tables) 

&#x20;

&#x20;

0 - 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 50 of 73                                                                                     

Database 

Design – ERD 

Design 

&#x20;

\[10 Marks] 

Tables missing or 

incomplete 

ERD partially correct ERD mostly correct Fully correct ERD, 

relationships clearly 

represented 

&#x20;

&#x20;

0 – 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

Report Design 

&#x20;

\[20 Marks] 

Reports missing, 

mostly incorrect, or 

not usable; do not 

meet client needs. 

&#x20;

Some reports 

implemented correctly; 

minor errors or missing 

reports; partially meets 

client needs. 

Most reports correctly 

implemented and 

usable; minor errors; 

mostly meets client 

requirements. 

&#x20;

All reports correctly 

implemented, 

accurate, and fully 

usable; meets all 

client requirements; 

clear and professional 

layout. 

&#x20;

&#x20;

0 – 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

Document 

Formatting / 

Layout 

&#x20;

\[5 Marks] 

Layout, numbering, 

headings unclear 

Some formatting is 

correct 

Mostly correct; minor 

inconsistencies 

Layout professional; 

headings, numbering, 

tables, and diagrams 

clear 

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

TOTAL /100 

&#x20;

Task 2 consists of two documents: Requirement Analysis and System Design. Each document is marked out of 100 and 

contributes equally (25% each) toward Task 2. The final Task 2 mark is calculated by averaging the two marks. 

&#x20;

Overall Task 2 Mark = (Requirement Analysis Mark + System Design Mark) / 2  

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 51 of 73                                                                                     

Assessment Sheet (Marking Rubric) – Project Report 

&#x20;

&#x20;

&#x20;

MODULE NAME: MODULE CODE: 

WIL – Work Integrated Learning XISD5319 

&#x20;

GROUP MEMBERS 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

&#x20;

PROJECT REPORT 

Marking 

Criteria 

Does not meet the 

required standard 

Meets the required 

standard 

&#x20;Partially exceeds 

the required 

standard 

&#x20;

Greatly exceeds the 

required standard 

&#x20;

Feedback 

Combined 

Document 

Structure 

&#x20;

\[10 Marks] 

Documents not 

combined; structure 

unclear or incorrect 

Documents combined; 

basic structure followed 

Well-structured; minor 

inconsistencies 

All documents clearly 

combined into one 

coherent report with 

correct order 

&#x20;

&#x20;

0 - 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

&#x20; 

Include this RUBRIC with your submission as part of the ONE document.  

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 52 of 73                                                                                     

Project Plan – 

Revised \& 

Improved 

&#x20;

\[15 Marks]  

No improvements 

made; feedback 

ignored 

Some feedback 

addressed 

Most feedback 

addressed with clear 

changes 

All lecturer feedback 

addressed and clearly 

documented with sub

heading and 

explanations 

&#x20;

&#x20;

0 - 5 Marks 6 - 8 Marks 9 - 12 Marks 13 - 15 Marks  

&#x20;

Requirement 

Analysis – 

Revised \& 

Improved 

&#x20;

\[20 Marks] 

Minimal or no 

revisions made 

Some improvements 

evident 

Most feedback 

incorporated 

All feedback 

incorporated, analysis 

clear and consistent 

with sub-heading and 

explanations on 

changes made 

&#x20;

&#x20;

0 - 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

System Design – Revised \& 

Improved 

&#x20;

\[20 Marks] 

Design content 

unchanged or 

incorrect 

Some design content 

improvements made 

Most design elements 

refined 

Design fully refined, 

accurate, and aligned 

with feedback, sub

heading and 

explanations clearly 

made  

&#x20;

&#x20;

0 - 9 Marks 10 - 12 Marks 13 - 14 Marks 15 - 20 Marks  

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 53 of 73                                                                                     

Prototype 

Design \& 

Functionality  

&#x20;

\[25 Marks] 

Prototype missing or 

poorly designed 

Basic prototype; limited 

interaction design 

Prototype mostly 

complete; minor gaps 

Prototype fully 

designed; reflects 

system design, 

simulates navigation, 

inputs, requests, and 

reports 

&#x20;

&#x20;

0 - 10 Marks 11 - 14 Marks 15 - 19 Marks 20 - 25 Marks  

Evidence and 

Supporting 

Material 

&#x20;

\[5 Marks] 

Screenshots or links 

missing 

Some screenshots or 

links provided 

Most screenshots and 

links included 

&#x20;

Clear screenshots 

included with labels 

and working 

Figma/GitHub or any 

other relevant links 

provided 

&#x20;

&#x20;

0 – 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

Document 

Formatting / 

Layout 

&#x20;

\[5 Marks] 

Poor layout; headings, 

numbering, or 

structure unclear 

Basic formatting applied Mostly consistent; 

minor issues 

Clear, consistent 

layout; headings, 

numbering, tables, 

and diagrams well 

presented 

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

TOTAL /100 

&#x20;

This final submission consists of the document mark, annexure marks and presentation rubric marks. Each of these 

sections is out of 100 and contributes toward the 25% weight. 

&#x20;

Project Report Mark = (Document Mark + (Peer + Self + Individual Presentation Mark) + Group Presentation Mark) / 3 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 54 of 73                                                                                     

ANNEXURE E – Presentation Rubric 

This is the rubric your lecturer will use to mark everyone in the group presentation. Please refer to this when preparing your presentation.  

&#x20;

&#x20;

NAME AND STUDENT NUMBER................................................................................      MODULE NAME AND CODE: .............................. 

&#x20;

CRITERIA 0-1 Does not meet the 

required standards 

2 – Meets the required 

standards 

3 – Partially exceeds the 

required standards 

4 – Exceeds the required 

standards 

TOTAL 

NON-VERBAL SKILLS (CCFO5) 

Audience Engagement 

&#x20;

&#x20;

&#x20;

&#x20;

&#x20;

&#x20;

&#x20;

&#x20;

 Makes no attempt to 

interact with the 

audience. 

 Unprepared - does 

not cope with 

interruptions during 

presentation. 

&#x20;

&#x20;

 Sometimes interacts 

with the audience. 

 Tense, anxious, 

appears defensive, 

distracting, unnatural 

and unnecessary 

movement. 

 Does not recover well 

when making 

mistakes. 

 Has frequent 

interaction with the 

audience. 

 Recovers quickly and 

smoothly when 

mistakes are made. 

&#x20;

 Holds attention through 

direct interaction with the 

audience.  

&#x20;

&#x20;

&#x20;        /4 

VERBAL SKILLS (CCFO5) 

GROUP DYNAMIC (CCFO2; CCFO3) 

Individual interaction with: 

&#x20;

Team members and  

Audience 

 Does not participate 

in the presentation.  

 Does not respond to 

feedback (verbal and 

nonverbal) from 

audience. 

&#x20;

&#x20;

 Little participation in 

the presentation. 

 Occasionally responds 

to feedback (verbal 

and nonverbal) from 

audience. 

 Participates in 

presentation, shares 

responsibilities with 

peers. 

 Frequently responds 

to feedback (verbal 

and nonverbal) from 

audience. 

 Participates 

enthusiastically in 

presentation, supports 

peers, takes lead when 

appropriate.  

 Smoothly integrates 

appropriate feedback 

(verbal and nonverbal) 

from audience into 

presentation. 

&#x20;

&#x20;          /4 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 55 of 73                                                                                     

&#x20;

Language and Delivery 

 Too loud/too soft, 

abrupt, 

condescending. 

 Inappropriate, in poor 

taste, mumbles, 

incorrect use of 

terminology. 

 Shows no interest in 

topic or activity/does 

not participate in oral 

part of presentation. 

&#x20;

 Cannot be heard by 

audience. 

 Unable to articulate 

ideas. 

 Mumbles, appears 

distracted or 

unfocused, reads 

notes word for word. 

 Varies volume and 

pitch. 

 Correct use and 

pronunciation of 

terms. 

 Thoughts well

articulated, uses own 

word 

 Clear, easy to listen to and 

articulate. 

 Correct and effective use 

of language. 

 Enthusiastic, relaxed, self

confident, seldom refers to 

notes, maintains the 

interest of the audience 

throughout the 

presentation. 

&#x20;

/4 

&#x20;

&#x20;

&#x20;

CRITERIA 0-1 Does not meet the 

required standards 

2 – Meets the required 

standards 

3 – Partially exceeds the 

required standards 

4 – Exceeds the required 

standards 

TOTAL 

VISUAL AIDS \& TIMING (CCFO5) 

Physical \& Electronic, 

e.g., posters, models, 

charts, video, computer 

simulation, PowerPoint 

slides. 

&#x20;

  Presentation is too 

short or takes much 

longer than allocated 

time.  

 No visual aid used for 

the presentation, or the 

PowerPoint 

presentation is of a low 

quality 

 Poor PowerPoint 

presentation, distracts 

the audience, adds 

nothing to the 

presentation. 

 Presentation is 

somewhat close to the 

allocated time. 

 PowerPoint 

presentation is 

relevant to topic and 

enhances 

understanding and 

explanation. 

 Length of presentation 

close to allocated time. 

 PowerPoint presentation 

supports and enhances the 

understanding and 

explanation of the topic. 

 Length of presentation 

close to allocated time. 

&#x20;

&#x20;       /4 

&#x20;

CRITERIA 0-1 Does not meet the 

required standards 

2 – Meets the required 

standards 

3 – Partially exceeds 

the required standards 

4 – Exceeds the required 

standards 

TOTAL 

SUBJECT KNOWLEDGE (CCFO1; CCFO4) 

&#x20; Demonstrates no 

understanding of 

concepts. 

 Is unable to answer 

any questions, when 

required. 

 Demonstrates limited 

understanding of 

concepts. 

 Has difficulty 

answering questions. 

 Demonstrates 

adequate 

understanding of 

concepts. 

 Able to answer most 

questions. 

 Demonstrates deep 

understanding of concepts. 

 Is able to provide in- depth 

explanations in response to 

all questions.  

&#x20;

&#x20;            /4 

IIE Module Manual                                                                                                                                                                                                                             

XISD5319/w 

GENERAL LECTURER FEEDBACK: 

……………………………………………………………………………………………………………………………………………………………………………………

……………………………………………………………………………………………………………………………………………………………………………………

……………………………………………………………………………………………………………………………………………………………………………………

……………………………………………………………………………………………………………………………………………………………………………………

……………………………………………………………………………………………… 

TOTAL 

/20 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     

Page 56 of 73                                                                                     

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 57 of 73                                                                                     

ANNEXURE F – Group Presentation Rubric 

&#x20;

MODULE NAME: MODULE CODE: 

WIL – Work Integrated Learning XISD5319 

&#x20;

GROUP MEMBERS 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

STUDENT NAME: 

STUDENT NUMBER: 

&#x20;

PRESENTATION  

Marking 

Criteria 

Does not meet the 

required standard 

Meets the required 

standard 

&#x20;Partially exceeds 

the required 

standard 

&#x20;

Greatly exceeds the 

required standard 

&#x20;

Feedback 

Problem 

Statement  

&#x20;

\[15 Marks] 

Problem domain not 

analysed; unclear 

overview 

Basic analysis 

presented; some results 

unclear 

Most of problem 

domain analysed; 

results mostly clear 

Complete analysis of 

problem domain; 

results clearly 

presented 

&#x20;

&#x20;

0 - 5 Marks 6 - 8 Marks 9 - 12 Marks 13 - 15 Marks  

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 58 of 73                                                                                     

Business 

Solution – 

Description of 

the System 

and 

Architecture 

&#x20;

\[5 Marks]  

System description 

missing or unclear 

Basic description; partial 

architecture or solution 

Mostly complete 

description; minor 

gaps 

Complete description; 

architecture fully clear 

&#x20;

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks 

&#x20;

&#x20;

Business 

Solution - How 

was it solved? 

&#x20;

\[10 Marks] 

Missing or unclear Some aspects explained Most aspects 

explained; minor gaps 

All aspects explained: 

solution domain, 

milestones, WBS, 

budgets 

&#x20;

&#x20;

0 - 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

Business 

Solution – User 

Requirements / 

Business 

Functionalities 

&#x20;

\[5 Marks] 

Missing or unclear Some requirements 

identified 

Most requirements 

identified 

All business 

functionalities 

identified and 

correctly linked 

&#x20;

&#x20;

&#x20;

&#x20;

0 - 4 Marks 5 Marks 6 - 7 Marks 8 - 10 Marks  

System 

Requirements – Value added? 

&#x20;

\[5 Marks] 

Missing or unclear Some description of 

client needs 

Mostly explained Fully explained; 

clearly satisfies client 

needs  

&#x20;

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 59 of 73                                                                                     

System 

Requirements – Requirement 

Analysis 

Content 

Explained 

&#x20;

\[15 Marks] 

Missing or unclear Partial content from 

documentation explained 

Mostly complete 

content discussed; 

minor omissions 

Complete content 

from requirement 

analysis 

documentation fully 

explained, relevant 

and consistent such 

as actors, functions, 

inputs, outputs, class 

diagrams  

&#x20;

0 - 5 Marks 6 - 8 Marks 9 - 12 Marks 13 - 15 Marks  

Database – 

Scope – 

Number of 

Tables 

&#x20;

\[5 Marks] 

Missing or unclear  Basic number of tables 

indicated 

Most tables indicated; 

minor omissions 

All required tables 

correctly indicated 

&#x20;

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

Database – 

Table 

Correctness – 

Fields and 

Data Types 

&#x20;

\[5 Marks] 

Missing or incorrect Some fields or data 

types correct 

Most fields correct; 

minor errors 

All fields and data 

types correct and 

consistent  

&#x20;

&#x20;

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

Database – 

Relationships - 

ERD 

&#x20;

\[5 Marks] 

ERD missing or 

incorrect 

Partially correct ERD Mostly correct ERD; 

minor issues 

Fully correct ERD: 

relationships clearly 

represented 

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             XISD5319/w 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     Page 60 of 73                                                                                     

System 

Prototype – 

Layout / 

Aesthetics / 

Forms 

&#x20;

\[5 Marks] 

Poor layout; unclear Basic layout and forms Mostly clear layout; 

minor issues 

Clear, professional 

layout and forms 

&#x20;

&#x20;

&#x20;

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

System 

Prototype - 

Friendliness 

&#x20;

\[5 Marks] 

Unfriendly interface Some consideration of 

user experience 

Mostly user-friendly; 

minor issues 

Fully user-friendly; 

intuitive interface 

&#x20;

&#x20;

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

System 

Prototype – 

Menus / 

Navigation 

&#x20;

\[5 Marks] 

Confusing or missing Basic menus/navigation Mostly correct menus; 

minor gaps 

Clear, logical, and 

consistent 

menus/navigation 

&#x20;

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

System 

Prototype - 

Functionality 

&#x20;

\[5 Marks] 

Non-functional or 

missing 

Partial functionality Mostly functional; 

minor issues 

Fully functional 

prototype with all 

features reflected 

&#x20;

&#x20;

0 - 1 Marks 2 - 3 Marks 4 Marks 5 Marks  

&#x20; 

IIE Module Manual                                                                                                                                                                                                                             

XISD5319/w 

Group 

Presentation 

Skills 

\[10 Marks] 

Poor presentation 

skills; unprofessional 

Basic presentation; 

minor issues 

Mostly effective 

presentation; minor 

errors 

Excellent 

presentation; team 

introduction, 

confidence, eye 

contact, pace, 

language, notes, 

dress, slides 

0 - 4 Marks 

5 Marks 

6 - 7 Marks 

TOTAL 

8 - 10 Marks 

/100 

© The Independent Institute of Education (Pty) Ltd 2026                                                                                                                                                                     

Page 61 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

ANNEXURE G - Professional Conduct in the 

Workplace 

1\. Introduction 

This learning unit is designed to highlight transferable skills which are necessary to 

succeed in the 21st century workplace. These skills include teamwork, critical thinking, 

high-level problem-solving, communication, self-management, and career readiness. 

After completing this learning unit, you should be able to:  

 

 

 

Conduct yourself professionally in the workplace; 

Apply appropriate interpersonal skills in a professional context; 

Develop yourself and promote your career. 

There are short videos and links embedded throughout the learning unit directing you 

to more readings on important topics. These are designed to give you a deeper 

understanding of some of the terms and terminology that you will encounter in this 

learning unit, as well as the circumstances that you may encounter as you enter the 

workplace. 

2\. Progressing from student-life to work-life 

In the South African economy, employment opportunities are available in a range of 

very different organisations such as local government, public administration, the 

banking industry, private business, non-profit organisations, and small, medium, and 

micro-sized enterprises (SMME). Each of these potential employers have their own 

rules, expectations and organisational cultures. This means that you, as a new 

employee, would need to adapt and fit into this new environment.  

The Future: How to create opportunities from change 

Source 

Run time: 1:50 

As you move into the workplace, it is your responsibility to manage yourself. When you 

were at school, somebody actively looked after you (your parents and teachers); at 

university you were encouraged to explore your identities and given more freedom of 

choice in your lives. However, you still had parents and lecturers who provided support 

and guided you.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 62 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

Once you enter the world of work, you are expected to behave in certain ways and be 

professional, efficient and effective in your role as an employee. Any actions you 

choose to follow will have consequences (both good and bad). It is your responsibility 

to ensure you follow any instructions from your line managers and take control of your 

own performance and reputation.  

Your first line of responsibility before moving into the workplace will be to secure 

interviews for yourself. Compile your curriculum vitae (CV) and include some specific 

information that would showcase your abilities and your educational achievements. 

Some information is considered irrelevant and should be excluded from your CV for 

various reasons. There are many CV templates on the internet that you can choose 

from. If you are applying for jobs that are predominantly in a corporate environment, 

then your CV should be simple and reflect the formality of the company. However, if 

you will be applying for jobs with an arty or creative edge then your CV can be much 

more elaborate and colourful.  

You could hear of potential jobs through various channels, such as: 

 

 

 

 

Word of mouth – someone you know may hear about a vacancy and pass on the 

information. 

Media – newspapers and the internet have thousands of jobs advertised.  

LinkedIn – create your own professional profile and upload your CV. Make 

connections and network in your chosen field.  

Recruitment companies. 

It is important to be professional in your job search and this includes professional email 

addresses. Email addresses which do not portray you as an employee with integrity 

should not be used. An email address such as IwantToParty@gmail.com or 

tequila@yahoo.com will not give a good first impression of you and may be considered 

junk mail and never be seen by the person who the email is addressed to. Choose a 

professional looking email address e.g. Vusi.Molefe@gmail.com.  

Each year you will have a meeting with your line manager or someone who manages 

your performance. This is normally called a Performance Review and will have a 

number of Key Performance Areas (KPAs) which your performance is measured 

against. You will be notified of these when you enter the workplace and relate to the 

job profile that you work in. These are reviewed annually as you grow in your job and 

take on more responsibility. Your salary increases will most probably be based on your 

KPA score.  

One of the most important areas for you to attend to is meeting deadlines. Businesses 

function on the timeous delivery of their products and services and in most cases the 

deadlines cannot be extended. Think about your salary, you expect to be paid at the 

same time every month. What would happen if someone missed a deadline and you 

were paid a week later or even worse, never received it? Often the work you will be 

required to complete by a deadline needs to move on to another person or department 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 63 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

and if you miss your deadline then you are holding up the process and putting those 

other employees under pressure to meet their deadlines.  

3\. Behaviour in the workplace 

Your new employer would expect you to conduct yourself professionally and ethically 

from the first day.  

Professionalism at the workplace 

Source 

Run time: 1:44 

Most employers will have an induction programme for new employees, where you will 

get an introduction into the sections and operations of your new environment. It is a 

good idea to be prepared and make the most of learning about your new work 

environment during the induction. But, there is far more that you would need to do and 

learn. This will help you to understand what is expected of you and what is seen as 

appropriate behaviour. When you start working in a new position, make sure you know 

what the organisation’s culture is. 

The more you understand your new work environment, the sooner you will be able to 

fit right in.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 64 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

Source 

These key skills are also referred to as interpersonal skills or soft skills in the 

workplace. Let us look a bit closer at each of these key skills: 

Communication skills 

Communication in the workplace must always be professional. It can never be on the 

same informal level as at home or with friends. If your office environment has a policy 

that English is the language of business, adhere to it. Professional communication at 

work includes language proficiency, reading, writing, problem-solving, and the use of 

information technologies.   

Both written and oral communication in the workplace must always be professional. 

There are many books and articles written on the dos and don’ts of office 

communication. Here are some of the most important ones:  

Communication Dos and Don’ts: 

DO 

Develop your “business vocabulary”: 

DON’T 

Never use poor grammar or slang. 

Texting in the workplace should only be 

done when it is absolutely necessary. 

This article on texting language. May be 

helpful on how to do this. 

Never use the abbreviated language 

that you use with your friends on social 

media. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 65 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

Listen to the presentations of your 

managers and research terms and 

terminology pertaining to your 

environment with which you are not 

familiar. 

Refrain from using inappropriate 

phrases or any form of sexist, racist or 

heteronormative language. 

Make use of a spelling and grammar  

checker when typing emails, reports 

and letters.  

Use the correct letterheads, stationery 

and templates for official business 

communication and refrain from using 

them for personal use. 

Do not let anger or frustration reflect in 

the tone of your verbal or written 

communication. Do not use CAPITAL 

LETTERS, bold font, slang or emoticons 

to indicate frustration. 

Never gossip or constantly complain 

about trivial matters or use abrasive 

language. 

But what about nonverbal communication in the workplace? Actions such a facial 

expression, eye contact, gestures and posture communicate far more that you could 

realise. It could even include the way you dress. Together with verbal communication, 

nonverbal communication may be used to as important cues to strengthen the 

message. As a new employee you should be aware how your nonverbal cues can be 

interpreted.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 66 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

Consider the following scenario:  

Your manager asks you to compile a report and then present this report at a meeting. 

This task provides you with a number of opportunities to showcase your abilities, work 

ethic, and performance. What choices would you need to make?  

There are many considerations, but those listed below are some of the important ones: 

 

 

Communication:  

o 

o 

The language used in your report. Is it suitable for the audience you will be 

presenting to? 

Verbal and non-verbal communication skills. 

Appearance: 

o 

o 

The clothes you will be wearing to do the presentation. This should again 

be appropriate for the audience and the occasion.  

It is not advisable to chew gum in an office environment if you are expected 

to have face-to-face meetings with people or do presentations.  

If you are unsure of what you are expected to do, then ask for assistance. Your 

manager would rather you do this than have a presentation which is not fit for purpose 

or lacks vital information. 

Meetings 

Conducting yourself professionally and actively participating in business meetings 

would require a good understanding of the different types of meetings, their purpose 

and structure. The business environment generally has regular meetings for a range 

of business reasons.  

Some examples are: 

 

 

 

 

Staff meetings; 

Product meetings; 

Stakeholder meetings; 

Committee meetings. 

Communication in these meetings follows strict meeting protocols. It is also a good 

idea to take notes during meetings, especially if they are used to allocate work and 

responsibilities. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 67 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

Telephone Etiquette 

You will be required to be professional in your telephone communication. It is good 

business practice to state your name when answering your phone. Be polite and take 

notes if you are being requested to do tasks or pass on a message. Getting the 

message communicated correctly is an important function in the workplace. 

Knowledge of Business phone etiquette will assist you in dealing with clients, suppliers 

and associates in a professional way that will promote both your image and your 

organisation’s reputation.  

Another important consideration is your phone’s ringtone. Keep it simple and 

professional.  

Teamwork and group work 

At work, you will be required to work with people, either formally in teams or informally 

by sharing office environments. Your success will depend on cooperation with 

individuals and groups. You need a special set of skills when working on a one-on-one 

situation or in teams. This will require people skills:  

Creating Value through People Skills (Source) 

To be a good team member, you would need to: 

 

 

 

 

 

Build a good rapport with other team members; 

Improve your listening skills; 

Develop speaking and presentation skills; 

Communicate to different audiences; 

Respect diversity; 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 68 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

 

 

 

 

 

Give and receive criticism more effectively without being offensive or taking the 

criticism personally; 

Be assertive and diligent; 

Resolve conflict and deal with difficult people; 

Develop negotiation skills; 

Build leadership skills. 

Many of these skills will be developed over time as you build experience in the 

workplace and receive further training. 

Office politics and social protocols 

All offices and organisations will experience office politics. There are many reasons 

why most work environments go through stages where office politics can cause 

problems. There are many reasons why these problems may surface and why this 

should be carefully managed.  

Some of the reasons include: 

 

 

 

 

 

Employees aspiring to be noticed; 

Employees overstep and cross boundaries and their authority; 

Employees lack supervision and control in the workplace; 

Gossip at work leads to poor office politics; 

Jealous colleagues (professional jealousy) or people who perceive others as a 

threat. 

As a professional, you are responsible for managing difficult situations. How can 

professional jealousy be prevented? 

You will be spending many hours at work. It is, therefore, important that these situations 

be handled with great care and professionalism to prevent conflict and to keep office 

relationships professional. 

Dealing with differences in opinion and conflict is an important life skill to have, which 

can be effectively used in the workplace. It is important to regulate your emotions and 

not take other individuals’ opinions personally. Do not email or phone anyone until you 

have thought through your response carefully and remove all emotions out of your 

communication. If you do not, you run the risk of inflaming the situation and coming 

across as volatile and unprofessional. 

Professional networking 

Networking with co-workers in the organisation and with professional bodies helps you 

to grow and develop your skills and career and build communities of practice. Social 

networking, such as creating professional profiles on LinkedIn, helps to open up 

opportunities, create awareness and build your professional portfolio. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 69 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

4\. Ethics, trust, honesty and integrity 

Ethical behaviour means you are doing the right thing for the right reasons. e.g. not 

taking home office stationery, using the company’s internet connectivity for personal 

use, gossiping about fellow employees, harassment and discrimination of any kind. 

There are various offences you could commit in the workplace for which you could 

possibly be fired. Many are related to ethics, such as stealing, revealing confidential 

information, insubordination, dereliction of duty, harassment and discrimination, etc. 

You want to trust your employer and believe that they will always have your best 

interests at heart. Your professional conduct will create a mutual trust relationship at 

the organisation. This requires ethical behaviour, knowing what is right and acting 

accordingly. Ethics is doing the right thing even when no one is watching.  

The following are some pointers that will guide you towards creating this trust 

relationship: 

 

 

 

 

 

 

 

 

 

Never exaggerate on a Curriculum Vitae or add skills and qualifications that you 

do not have. 

Be punctual for meetings and appointments. 

Meet deadlines. 

Do what you said you would do and communicate immediately if you are not able 

to honour your commitments. 

Conform to the organisational culture and stick to the “rules”. 

Be open and honest with your colleagues and manager if something goes wrong. 

Do not lie.  

Respect your organisation, their resources and management. 

Sensitive information must be kept confidential. This includes any information 

about your salary or other forms of remuneration. You may not discuss with other 

employees how much you earn. 

Do not use the organisation’s resources such as stationery, internet connectivity 

and telephones for personal purposes. 

5\. Managing professional spaces and appearances 

One of the biggest adjustments that is required when bridging the stage of being an 

informal student to a professional in the workplace is the dress code. Would you trust 

a Bank Manager who wears dirty shoes, chews gum and uses informal language or 

slang? You must dress for success – you must look the part if you want to succeed. 

Dressing appropriately will boost your self-confidence. Read this article for more 

information: 20 Personal Appearances Tips for the Workplace.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 70 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

In open office environments, it is particularly important to consider your colleagues in 

the shared space. These are some of the areas that can cause conflict: 

 Noise - Do not talk too loudly as you may distract your colleagues from their work. 

It is very difficult to concentrate when there is too much noise. 

 

Temperature - Do not adjust the temperature of the air conditioner. These are 

normally set at a standard temperature which is considered comfortable for the 

majority of people. This is around 23 degrees. If you feel too hot or cold, then 

plan to adjust your personal space (an extra jersey, lap blanket, or a desk fan) to 

your comfort level.  

 Neatness - Keep your office area neat and organised. You may be permitted to 

personalise your area with photographs or other small items. Keep these to the 

minimum so they do not intrude on your workspace. All décor must be 

appropriate and portray a professional image.  

 Smells – Keep the smelly food for home. Your colleagues may not appreciate 

your tuna or garlic-laced lunch. 

6\. Behaviour and conduct outside of working hours 

Your conduct outside of office hours is as important as your conduct during working 

hours. This is also true for your online behaviour. Recruiters and companies often 

scrutinise online social media and behaviour when they decide on the suitability of a 

candidate. If you are irresponsible and post inappropriate pictures or comments, it may 

cost you your job.  

The following are actions on social media that may have dire consequences for you as 

an employee: 

 

 

 

 

 

Making negative comments about your manager, your colleagues or the 

organisation; 

Making derogatory comments or commenting on controversial social media 

posts; 

Mentioning salaries, complaining about your salary or new job offers;  

Sharing photos of wild parties, alcohol consumption and nudity;  

Making threats online, even jokingly. 

The conduct and standards expected for online communication is often referred to as 

Netiquette. 

7\. Contracts and legal matters 

When you start working either permanently, as an intern or as a contract employee, 

you need to know what your responsibilities and rights are in advance. The very first 

document you will be expected to sign will be your conditions of service for 

employment. These are normally standard for colleagues in the same or similar 

positions but could have been customised to include additional responsibilities as the 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 71 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

job requires. Read your contracts carefully before signing them, as by signing them, 

you acknowledge that you are accepting the tasks specified. Ask if you do not 

understand certain clauses and information. 

8\. In Closing 

It is better to be well prepared and have the appropriate expectations when you enter 

the job market. In this learning unit we introduced some areas that will assist you in 

this preparation. It is also important to realise that we live in a fast-paced world where 

technology, information and situations constantly change. 

In summary, make sure that you always stay informed and well-prepared, keep records 

and conduct yourself in a way that will grow your opportunities to your long-term 

advantage.  

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 72 of 73                                                                                     

IIE Module Manual                                 

XISD5319/w 

9\. Bibliography 

Lawson, K. 2016. New Employee Orientation Training. Alexandra, Virginia: 

Association for Talent Development (ATD Workshop Series). \[Online]. Available at: 

https://ezproxy.iielearn.ac.za/login?url=http://search.ebscohost.com/login.aspx?direct

=true\&db=e020mww\&AN=1107620\&site=ehost-live  

National Research Council. 2012. Education for Life and Work: Developing 

Transferable Knowledge and Skills in the 21st Century. Washington, DC: The 

National Academies Press. https://doi.org/10.17226/13398. \[Accessed 22 March 

2022]. 

Robles, M. M. 2012. ‘Executive Perceptions of the Top 10 Soft Skills Needed in 

Today’s Workplace’, Business Communication Quarterly, 75(4), pp.453–465. doi: 

10.1177/1080569912460400. 

© The Independent Institute of Education (Pty) Ltd 2026                                                        

Page 73 of 73                                                                                      



