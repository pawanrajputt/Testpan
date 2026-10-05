<style>
body {
    font-family: 'cursive';
    background-color: #e7e7e7;
    color: #777;
    font-weight: 300;
}

.tab-wrap {
    -webkit-transition: 0.3s box-shadow ease;
    transition: 0.3s box-shadow ease;
    border-radius: 6px;
    max-width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    position: relative;
    list-style: none;
    background-color: #fff;
    margin: 40px 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}

.tab-wrap:hover {
    box-shadow: 0 12px 23px rgba(0, 0, 0, 0.23), 0 10px 10px rgba(0, 0, 0, 0.19);
}

.tab {
    display: none;
}

.tab:checked:nth-of-type(1)~.tab__content:nth-of-type(1) {
    opacity: 1;
    -webkit-transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease, 0.8s -webkit-transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    -webkit-transform: translateY(0px);
    transform: translateY(0px);
    text-shadow: 0 0 0;
}

.tab:checked:nth-of-type(2)~.tab__content:nth-of-type(2) {
    opacity: 1;
    -webkit-transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease, 0.8s -webkit-transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    -webkit-transform: translateY(0px);
    transform: translateY(0px);
    text-shadow: 0 0 0;
}

.tab:checked:nth-of-type(3)~.tab__content:nth-of-type(3) {
    opacity: 1;
    -webkit-transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease, 0.8s -webkit-transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    -webkit-transform: translateY(0px);
    transform: translateY(0px);
    text-shadow: 0 0 0;
}

.tab:checked:nth-of-type(4)~.tab__content:nth-of-type(4) {
    opacity: 1;
    -webkit-transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease, 0.8s -webkit-transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    -webkit-transform: translateY(0px);
    transform: translateY(0px);
    text-shadow: 0 0 0;
}

.tab:checked:nth-of-type(5)~.tab__content:nth-of-type(5) {
    opacity: 1;
    -webkit-transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s -webkit-transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    transition: 0.5s opacity ease-in, 0.8s transform ease, 0.8s -webkit-transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    -webkit-transform: translateY(0px);
    transform: translateY(0px);
    text-shadow: 0 0 0;
}

.tab:first-of-type:not(:last-of-type)+label {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.tab:not(:first-of-type):not(:last-of-type)+label {
    border-radius: 0;
}

.tab:last-of-type:not(:first-of-type)+label {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.tab:checked+label {
    background-color: #fff;
    box-shadow: 0 -1px 0 #fff inset;
    cursor: default;
}

.tab:checked+label:hover {
    box-shadow: 0 -1px 0 #fff inset;
    background-color: #fff;
}

.tab+label {
    box-shadow: 0 -1px 0 #eee inset;
    border-radius: 6px 6px 0 0;
    cursor: pointer;
    display: block;
    text-decoration: none;
    color: #333;
    -webkit-box-flex: 3;

    -ms-flex-positive: 3;
    flex-grow: 3;
    text-align: center;
    background-color: #f2f2f2;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    text-align: center;
    -webkit-transition: 0.3s background-color ease, 0.3s box-shadow ease;
    transition: 0.3s background-color ease, 0.3s box-shadow ease;
    height: 50px;
    box-sizing: border-box;
    padding: 15px;
}

.tab+label:hover {
    background-color: #f9f9f9;
    box-shadow: 0 1px 0 #f4f4f4 inset;
}

.tab__content {
    padding: 10px 25px;
    background-color: transparent;
    position: absolute;
    width: 100%;
    z-index: -1;
    opacity: 0;
    left: 0;
    -webkit-transform: translateY(-3px);
    transform: translateY(-3px);
    border-radius: 6px;
}
</style>
<?php 
include('header_new_pp.php');
//include_once("db_connect.php");
?>
<div class="tab-wrap">
   <!-- active tab on page load gets checked attribute -->
   <input type="radio" id="tab1" name="tabGroup1" class="tab" checked>
   <label for="tab1"><strong>Privacy Policy</strong></label>
   <input type="radio" id="tab2" name="tabGroup1" class="tab">
   <label for="tab2"><strong>Term & Condition</strong></label>
   <input type="radio" id="tab3" name="tabGroup1" class="tab">
   <label for="tab3"><strong>Payment Policy</strong></label>
    <input type="radio" id="tab4" name="tabGroup1" class="tab">
   <label for="tab4"><strong>Subscriber Terms - BookMyTestCenter</strong></label>
   <div class="tab__content">
      <h3>Privacy Policy</h3>
        <div class="form-group col-12 col-lg-12">
    <label style="font-size:15px; color:#333">
<p>Testpan India Private Limited ("us", "we", or "Testpan", which also includes its affiliates) is a trusted infrastructure and test delivery provider for organizations of public as well as private sector.</p>

<p>Testpan India Private Limited is the author and publisher of the mobile application "BookMyTestCenter" ("Application")   as well as software and applications provided by Testpan, including but not limited to the mobile application. </p>  
 

<p>This privacy policy governs your use of the Application and the other associated/ancillary applications, products, websites and services managed by the Company Testpan India Private Limited.</p>

<p>We created this Privacy Policy to demonstrate our commitment to the protection of your privacy and your personal information. Your use of and access to the Services is subject to this Privacy Policy and our Terms of Use. Any capitalized term used but not defined in this Privacy Policy shall have the meaning attributed to it in our Terms of Use.</p> 

<p>BY USING THE APPLICATION, SERVICES OR BY OTHERWISE GIVING YOUR INFORMATION YOU WILL BE DEEMED TO HAVE READ, UNDERSTOOD AND AGREED TO THE POLICIES OUTLINED IN THIS PRIVACY POLICY AND AGREE TO BE BOUND BY THE PRIVACY POLICY. YOU HEREBY CONSENT TO OUR COLLECTION, USE AND SHARING, DISCLOSURE OF YOUR INFORMATION AS DESCRIBED IN THIS PRIVACY POLICY. WE PREVAIL THE RIGHT TO UPDATE THE PRIVACY POLICY ANY TIME AT OUR SOLE DISCRETION. IF YOU DO NOT AGREE WITH THIS PRIVACY POLICY AT ANY TIME, DO NOT USE ANY OF THE SERVICES OR GIVE US ANY OF YOUR INFORMATION. IF YOU USE THE SERVICES ON BEHALF OF SOMEONE ELSE (SUCH AS YOUR CHILD) OR AN ENTITY (SUCH AS YOUR EMPLOYER), YOU REPRESENT THAT YOU ARE AUTHORISED BY SUCH INDIVIDUAL OR ENTITY TO (I) ACCEPT THIS PRIVACY POLICY ON SUCH INDIVIDUAL'S OR ENTITY'S BEHALF, AND (II) CONSENT ON BEHALF OF SUCH INDIVIDUAL OR ENTITY TO OUR COLLECTION, USE AND DISCLOSURE OF SUCH INDIVIDUAL'S OR ENTITY'S INFORMATION AS DESCRIBED IN THIS PRIVACY POLICY.</p>

<p>1. WHY THIS PRIVACY POLICY?</p>
<p>
This Privacy Policy is published in compliance with, inter alia:
<li>Section 43A of the Information Technology Act, 2000</li>
<li>Regulation 4 of the Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Information) Rules, 2011 (the "SPI Rules")</li>
<li>Regulation 3(1) of the Information Technology (Intermediaries Guidelines) Rules, 2011.</li>

<p>This Privacy Policy states the following:</p>
<p>The type of information collected from the Users, including Personal Information (as defined in paragraph 2 below) and Sensitive Personal Data or Information (as defined in paragraph 2 below) relating to an individual; The purpose, means and modes of collection, usage, processing, retention and destruction of such information; and How and to whom Testpan will disclose such information.
</p>



<p>2. COLLECTION OF PERSONAL INFORMATION</p>

<p>Generally some of the Services require us to know who you are so that we can best meet your needs. The Application   records the information you provide when you download and register for the Application or Services. When you register with us, you generally provide the following data: </p>
<li>Contact information (such as your email address and phone number)</li>
<li>GPS, camera & storage</li>
<li>demographic data (such as your gender, your date of birth and your pin code)</li>
<li>data regarding your usage of the services</li>
<li>other information that you voluntarily choose to provide to us (such as information shared by you with us through emails or letters.</li>
<p>The said information collected from you by Testpan may constitute 'personal information' or 'sensitive personal data or information' under the SPI Rules.</p>

<p>"Personal Information" is defined under the SPI Rules to mean any information that relates to a natural person, which, either directly or indirectly, in combination with other information available or likely to be available to a body corporate, is capable of identifying such person.</p>
<p>The SPI Rules further define "Sensitive Personal Data or Information" of a person to mean personal information about that person relating to:</p>
<li>passwords</li>
<li>financial information such as bank accounts, credit and debit card details or other payment instrument details</li>
<li>biometric information</li>
<li>information received by body corporate under lawful contract or otherwise</li>
<li>call data records.</li>

<p>The Application/ Services may gather your certain information automatically, including, but not limited to, the type of mobile device used by you, your mobile devices unique device ID, the IP address of your mobile device, your mobile operating system, the type of mobile internet browsers used, and the information about the way you use the application/services. For most mobile applications, Testpan also gathers the other relevant information as per the permission you provide.</p>
<p>Testpan will be free to use, collect and disclose information that is freely available in the public domain without your consent.</p>

<p>3. PRIVACY STATEMENTS</p>

<p>3.1 ALL USERS NOTE:</p>

<p>This section applies to all users.</p>

<p>3.1.1   Accordingly, a state of every User's utilization of and access to the Services is their acknowledgment of the Terms of Use, which additionally includes acknowledgment of the conditions of this Privacy Policy. Any User that doesn't agree with any provisions of the same has the choice to end the Services provided by Testpan right away.</p>

<p>3.1.2    An indicative list of information that Application may require you to provide to enable your use of the Services is provided in the Clause 2 to this Privacy Policy.</p>

<p>3.1.3     All the information provided to Testpan by a User, including Personal Information or any Sensitive Personal Data or Information, is voluntary. You understand that Testpan may use certain information of yours, which has been designated as Personal Information or 'Sensitive Personal Data or Information' under the SPI Rules, (a) for the purpose of providing you the Services, (b) for commercial purposes and in an aggregated or non-personally identifiable form for research, statistical analysis and business intelligence purposes, (c) for sale or transfer of such research, statistical or intelligence data in an aggregated or non-personally identifiable form to third parties and affiliates, (d) debugging customer support related issues. Testpan also reserves the right to use information provided by or about the End-User for the following purposes:</p>
<p>
<li>Publishing such information on the Application</li>
<li>Contacting End-Users for offering new products or services</li>
<li>Contacting End-Users for taking product and Service feedback</li>
<li>Analyzing software usage patterns for improving product design and utility</li>
<li>Analyzing anonymous practice information for commercial use</li>
</p>
<p>If you have voluntarily provided your Personal Information to Testpan for any of the purposes stated above, you hereby consent to such collection and use of such information by Testpan. However, Testpan shall not contact you on your telephone number(s) for any purpose including those mentioned in this sub-section 4.1, if such telephone number is registered with the Do Not Call registry ("DNC Registry") under the PDPA without your express, clear and un-ambiguous written consent.</p>

<p>3.1.4     Collection, use and disclosure of information which has been designated as Personal Information or Sensitive Personal Data or Information' under the SPI Rules requires your express assent. By affirming your assent to this Privacy Policy, you provide your assent to such use, collection and disclosure as required under applicable law.</p>

<p>3.1.5     Testpan does not control or endorse the content, messages or information found in any Services and, therefore, Testpan specifically disclaims any liability with regard to the Services and any actions resulting from your participation in any Services, and you agree that you waive any claims against Testpan relating to same, and to the extent such waiver may be ineffective, you agree to release any claims against Testpan relating to the same.</p>

<p>3.1.6    You are responsible for keeping the information you send to us correct, such as your contact details given as part of account registration. If your personal information changes, you can correct, delete inaccuracies or alter information by posting the change on our member information page or by contacting us via Email. We will make good faith efforts to make requested changes in our then active databases as soon as reasonably practicable. If you provide any information that is untrue, inaccurate, out of date or incomplete (or becomes untrue, inaccurate, out of date or incomplete), or Testpan has reasonable grounds to suspect that the information provided by you is untrue, inaccurate, out of date or incomplete, Testpan may, at its sole discretion, discontinue the provision of the Services to you. There may be circumstances where Testpan will not correct, delete or update your Personal Data, including (a) where the Personal Data is opinion data that is kept solely for evaluative purpose; and (b) the Personal Data is in documents related to a prosecution if all proceedings relating to the prosecution have not been completed.</p>

<p>3.1.7     If you wish to cancel your account or request that we no longer use your information to provide you Services, contact us through Email. We will retain your information for as long as your account with the Services is active and as needed to provide you the Services. We shall not retain such information for longer than is required for the purposes for which the information may lawfully be used or is otherwise required under any other law for the time being in force. After a period of time, your data may be anonymous and aggregated, and then may be held by us as long as necessary for us to provide our Services effectively, but our use of the anonymous data will be solely for analytic purposes. Please note that your withdrawal of consent or cancellation of account may result in Testpan being unable to provide you with its Services or to terminate any existing relationship Testpan may have with you.</p>

<p>3.1.8    If you wish to opt-out of receiving non-essential communications such as promotional and marketing-related information regarding the Services, please send us an email at admin@testpanindia.com.</p>
 
<p>3.1.9  Testpan may require the User to pay with a credit card, wire transfer, debit card or cheque for Services for which subscription amount(s) is/are payable. Testpan will collect such User's credit card number and/or other financial institution information such as bank account numbers and will use that information for the billing and payment processes, including but not limited to the use and disclosure of such credit card number and information to third parties as necessary to complete such billing operation. Verification of credit information, however, is accomplished solely by the User through the authentication process. User's credit-card/debit card details are transacted upon secure sites of approved payment gateways which are digitally under encryption, thereby providing the highest possible degree of care as per current technology. However, Testpan provides you an option not to save your payment details. User is advised, however, that internet technology is not full proof safe and User should exercise discretion on using the same.</p>

<p>3.1.10 Due to the communications standards on the Internet, when a User or the End-User or anyone download the Application, Testpan automatically receives the IP address of the mobile  from which anyone  download the application.  Testpan also receives, email patterns, as well as the name of User's ISP. This information is used to analyze overall trends to help Testpan improve its Service. The linkage between User's IP address and User's personally identifiable information is not shared with or disclosed to third parties. Notwithstanding the above, Testpan may share and/or disclose some of the aggregate findings (not the specific data) in anonymous form (i.e., non-personally identifiable) with advertisers, sponsors, investors, strategic partners, and others in order to help grow its business.</p>

<p>3.1.11 The Application uses cookies to improve the user interface and the Application experience. The browser places cookies on their hard drive to save the record for future, in order to track and check the information. Each user is free to select the browser to avoid cookies, or to alert when cookies are being sent. If in case, you restrict the cookies, the Application may be limited in the use of some of the features.</p>

<p>3.1.12 A User may have limited access to the Application without creating an account on the Application. In order to have access to all the features and benefits on our Application, a User must first get itself registered on our Application. To create an account, a User is required to provide the following information, which such User recognizes and expressly acknowledges is Personal Information allowing others, including Testpan, to identify the User: name, User ID, email address, country, ZIP/postal code, age, phone number, password chosen by the User and valid financial account information.</p> 

<p>3.1.13 This Privacy Policy applies to Services that are owned and operated by Testpan. Testpan does not exercise control over the sites displayed as search results or links from within its Services. These other sites may place their own cookies or other files on the Users mobile, collect data or solicit personal information from the Users, for which Testpan is not responsible or liable. Accordingly, Testpan does not make any representations concerning the privacy practices or policies of such third parties or terms of use of such websites or applications, nor does Testpan guarantee the accuracy, integrity, or quality of the information, data, text, software, sound, photographs, graphics, videos, messages or other materials available on such applications / websites. The inclusion or exclusion does not imply any endorsement by Testpan of the website / application, the website's / application provider, or the information on the application / website. If you decide to visit a third party application / website linked to the Website, you do this entirely at your own risk. Testpan encourages the User to read the privacy policies of that application / website.</p>

<p>3.1.14 The Application may enable User to communicate with other Users or to post information to be accessed by others, whereupon other Users may collect such data. Such Users, including any moderators or administrators, are not authorized Testpan representatives or agents, and their opinions or statements do not necessarily reflect those of Testpan, and they are not authorized to bind Testpan to any contract. Testpan hereby expressly disclaims any liability for any reliance or misuse of such information that is made available by Users or visitors in such a manner.</p>

<p>3.1.15 Testpan does not collect information about the visitors of the Application from other sources, such as public records or bodies, or private organizations, save and except for the purposes of registration of the Users (the collection, use, storage and disclosure of which each End User must agree to under the Terms of Use in order for Testpan to effectively render the Services).</p>

<p>3.1.16 Testpan maintains a strict "No-Spam" policy, which means that Testpan does not intend to sell, rent or otherwise give your e-mail address to a third party without your consent.</p>

<p>3.1.17 Testpan has implemented best international market practices and security policies, rules and technical measures to protect the personal data that it has under its control from unauthorized access, improper use or disclosure, unauthorized modification and unlawful destruction or accidental loss. However, for any data loss or theft due to unauthorized access to the User's electronic devices through which the User avails the Services, Testpan shall not be held liable for any loss whatsoever incurred by the User.</p>

<p>3.1.18 Testpan implements reasonable security practices and procedures and has a comprehensive documented information security programme and information security policies that contain managerial, technical, operational and physical security control measures that are commensurate with respect to the information being collected and the nature of Testpan's business.</p>

<p>3.1.19 Testpan takes your right to privacy very seriously and other than as specifically stated in this Privacy Policy, will only disclose your Personal Information in the event it is required to do so by law, rule, regulation, law enforcement agency, governmental official, legal authority or similar requirements or when Testpan, in its sole discretion, deems it necessary in order to protect its rights or the rights of others, to prevent harm to persons or property, to fight fraud and credit risk, or to enforce or apply the Terms of Use.</p>

<p>3.2 END-USERS NOTE:</p>

<p>This section applies to all End-Users.</p>

<p>3.2.1 As part of the registration/application creation and submission process that is available to End-Users on this Application, certain information, including Personal Information or Sensitive Personal Data or Information is collected from the End-Users.</p>

<p>3.2.2 All the statements in this Privacy Policy apply to all End-Users, and all End-Users are therefore required to read and understand the privacy statements set out herein prior to submitting any Personal Information or Sensitive Personal Data or Information to Testpan, failing which they are required to leave the Application immediately.</p>

<p>3.2.3 If you have inadvertently submitted any such information to Testpan prior to reading the privacy statements set out herein, and you do not agree with the manner in which such information is collected, processed, stored, used or disclosed, then you may access, modify and delete such information by using options provided on the Application. In addition, you can, by sending an email to admin@testpanindia.com, inquire whether Testpan is in possession of your personal data, and you may also require Testpan to delete and destroy all such information.</p>

<p>3.2.4 End-Users personally identifiable information, which they choose to provide on the Application, is used to help the End-Users describe/identify themselves. Other information that does not personally identify the End-Users as an individual, is collected by Testpan from End-Users (such as, patterns of utilization described above) and is exclusively owned by Testpan. Testpan may also use such information in an aggregated or non-personally identifiable form for research, statistical analysis and business intelligence purposes, and may sell or otherwise transfer such research, statistical or intelligence data in an aggregated or non-personally identifiable form to third parties and affiliates.</p> 

<p>3.2.5 Testpan will communicate with the End-Users through email, phone and notices posted on the Application or through other means available through the service, including text and other forms of messaging. The End-Users can change their e-mail and contact preferences at any time by logging into their "Account" in the Application and changing the account settings.</p>

<p>3.2.6 At times, Testpan conducts a User survey to collect information about End-Users preferences. These surveys are optional and if End-Users choose to respond, their responses will be kept anonymous. Similarly, Testpan may offer contests to qualifying End-Users in which we ask for contact and demographic information such as name, email address and mailing address. The demographic information that Testpan collects in the registration process and through surveys is used to help Testpan improve its Services to meet the needs and preferences of End-Users.</p>

<p>3.2.7 All Testpan employees and data processors, who have access to, and are associated with the processing of sensitive personal data or information, are obliged to respect the confidentiality of every End-Users Personal Information or Sensitive Personal Data and Information. Testpan has put in place procedures and technologies as per good industry practices and in accordance with the applicable laws, to maintain security of all personal data from the point of collection to the point of destruction. Any third-party data processor to which Testpan transfers Personal Data shall have to agree to comply with those procedures and policies, or put in place adequate measures on their own.</p>

<p>3.2.8 Testpan may also reveal or transfer End-Users personal and other information provided by a User, to a third party as part of reorganization or a sale of the assets of a Testpan corporation division or company. Any third party to which Testpan transfers or sells its assets will have the right to continue to use the personal and other information that End-Users provide to us, in accordance with the Terms of Use.</p>

<p>3.2.9 To the extent necessary to provide End-Users with the Services, Testpan may provide their Personal Information to third party contractors who work on behalf of or with Testpan to provide End-Users with such Services, to help Testpan communicate with End-Users or to maintain the Application. Generally these contractors do not have any independent right to share this information; however certain contractors who provide services on the Application, including the providers of online communications services, may use and disclose the personal information collected in connection with the provision of these Services in accordance with their own privacy policies. In such circumstances, you consent to us disclosing your Personal Information to contractors, solely for the intended purposes only.</p>

<p>4. CONFIDENTIALITY AND SECURITY</p>

<p>4.1 Your Personal Information is maintained by Testpan in electronic form on its equipment, and on the equipment of its employees. Such information may time to time be converted to physical form. Testpan takes all necessary precautions to protect your personal information both online and off-line, and implements reasonable security practices and measures including certain managerial, technical, operational and physical security control measures that are commensurate with respect to the information being collected and the nature of Testpan's business.</p>

<p>4.2 No administrator at Testpan will have knowledge of your password. It is important for you to protect against unauthorized access to your password, your computer and your mobile phone. Be sure to log out from the Application when finished. Testpan does not undertake any liability for any unauthorized use of your account and password. If you suspect any unauthorized use of your account, you must immediately notify Testpan by sending an email to admin@testpanindia.com. You shall be liable to indemnify Testpan due to any loss suffered by it due to such unauthorized use of your account and password.</p>

<p>4.3 Testpan makes all User information accessible to its employees, agents or partners and third parties only on a need-to-know basis, and binds only its employees to strict confidentiality obligations.</p>

<p>4.4 Testpan is not responsible for the confidentiality, security or distribution of your Personal Information by our partners and third parties outside the scope of our agreement with such partners and third parties. Further, Testpan shall not be responsible for any breach of security or for any actions of any third parties or events that are beyond the reasonable control of Testpan including but not limited to, acts of government, computer hacking, unauthorized access to computer data and storage device, computer crashes, breach of security and encryption, poor quality of Internet service or telephone service of the User etc.</p>

<p>5. CHANGE TO PRIVACY POLICY</p>

<p>Testpan may update this privacy policy at any time at its sole discretion. In the event there are significant modifications in the privacy policy, Testpan will revise the mentioned updated date at the bottom of this page and will share with users on the Application. You are required to check this page persistently. It will help you to stay updated about the latest modifications. If you do not agree with this privacy policy at any time, do not use any of the services or give us any of your information. Your constant use of the services after any modification in this privacy policy will constitute your acceptance to those changes.</p>

<p>6. CHILDREN'S AND MINOR'S PRIVACY</p>

<p>Content that is prohibited for children such as scandalous, obscene matter or anything which is against the morality and facilitates threats, harassment or bullying are subject to immediate removal from the Application.</p>

<p>7. CONSENT TO THIS POLICY</p>

<p>You acknowledge that this Privacy Policy is a part of the Terms of Use of the Application and the other Services, and you agree that becoming a user of the Application and its Services signifies your assent to this Privacy Policy and consent to Testpan using, collecting, processing and/or disclosing your Personal Information in the manner and for the purposes set out in this Privacy Policy. Your visit to the Application and use of the Services is subject to this Privacy Policy and the Terms of Use.</p>

</label>	</div>
   </div>
   <div class="tab__content">
      <h3>Term & Condition</h3>
       <div class="form-group col-12 col-lg-12">
    <label style="font-size:15px; color:#333">

<p>1. NATURE AND APPLICABILITY OF TERMS</p>

<span>The terms and privacy policy together constitute a legal agreement ("Agreement") between you and Testpan in connection with your visit to the Application and your use of the services. 
By downloading or accessing the Application to use the Services, you irrevocably accept all the conditions stipulated in this Agreement, the Subscription Terms of Service and Privacy Policy, as available on the Application, and agree to abide by them. This Agreement supersedes all previous oral and written terms and conditions (if any) communicated to you relating to your use of the Application to avail the Services. By availing any Service, you signify your acceptance of the terms of this Agreement.

We reserve the right to modify or terminate any portion of the agreement for any reason and at any time. Such modifications shall be informed to you in writing. You should read the agreement properly and at regular intervals. Your use of the Application after any such modification constitutes your agreement to follow and be bound by the agreement so modified. If you do not accept the terms and conditions stated herewith, you will not be able to proceed with this site. 

Your access to the use of Application and the services will be solely at the discretion of Testpan.

<p>The agreement is published in compliance of, and is governed by the provisions of Indian law, including but not limited to:</p>
<li>The Indian Contract Act, 1872,</li>
<li>The (Indian) Information Technology Act, 2000</li>
<li>The rules, regulations, guidelines and clarifications framed there under, including the (Indian) Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Information) Rules, 2011 (The "SPI Rules")</li>
<li>The (Indian) Information Technology (Intermediaries Guidelines) Rules, 2011 (The "IG Rules")</li>
</span>
<br />
<p>2. CONDITIONS OF USE</p>

<span>You are not permitted to use the Application or services for nay unlawful purpose or any purpose prohibited under this clause. You are not permitted to use the Application or services in any way that could damage the APPLICATION, services or general business of the company.</span>
<p>You are further not permitted to use the Application or services:</p>
<li>To harass, abuse or threaten others or otherwise violate any person's legal right</li>
<li>To violate any intellectual property rights of company or any third party</li>
<li>To upload or otherwise disseminate any computer viruses or other software that may damage the property of another</li>
<li>To commit any fraud</li>
<li>To engage in or create any unlawful gambling</li>
<li>To publish or distribute any obscene or defamatory material</li>
<li>To publish or distribute any material that provokes violence, hate, or discrimination towards any group</li>
<li>To unlawfully gather information about others.</li>

<br />
<p>3.1 END-USER/USER ACCOUNT AND DATA PRIVACY</p>

<p>3.1.1 The expressions "personal information" and "sensitive personal data or information" are characterized under the SPI Rules, and are imitated in the Privacy Policy.</p>

<p>3.1.2 Testpan may by its Services, gather data identifying the devices through which you access the Application, and anonymous information of your utilization. The gathered data will be utilized uniquely for improving the nature of Testpan's administrations and to assemble new administrations.</p>

<p>3.1.3 The Application permits Testpan to approach enrolled Users personal email or telephone number, for correspondence reason in order to give you a better method for booking the center and for obtaining feedback.</p>

<p>3.1.4 The Privacy Policy sets out, inter-alia:</p>
<li>The kind of data gathered from users, including sensitive personal data or information</li>
<li>The purpose, means and modes of use of such data</li>
<li>How and to whom Testpan will disclose such data and</li>
<li>Other information mandated by the SPI Rules.</li>

<p>3.1.5 The User is expected to read and understand the Privacy Policy, in order to ensure that he or she has the knowledge of, inter-alia:</p>
<li>The fact that certain data is being collected</li>
<li>The purpose for which the data is being collected</li>
<li>The nature of collection and maintenance of the data</li>
<li>The name and address of the office that is collecting the data and the office that will retain the data</li>
<li>The numerous rights accessible to such Users in regard of such data.</li>

<p>3.1.6 Testpan shall not be responsible in any manner for the authenticity of the personal information or sensitive personal data or information provided by the User to Testpan or to some other individual following up on behalf of Testpan.</p>

<p>3.1.7 The User is responsible for maintaining the confidentiality of the User's account access information and password, if the User is enrolled on the Application. The User shall be responsible for all usage of the User's account and password, whether or not authorized by the User. The User shall immediately notify Testpan of any actual or suspected unauthorized use of the User's account or password. Although Testpan will not be liable for your losses caused by any unauthorized use of your account, you may be liable for the losses of Testpan or such other parties as the case may be, due to any unauthorized use of your account.</p>

<p>3.1.8 If a User provides any information that is false, inaccurate, not current or incomplete (or becomes false, inaccurate, not current or incomplete), or Testpan has reasonable grounds to suspect that such information is false, inaccurate, not current or incomplete; Testpan has the right to discontinue the Services to the User at its sole discretion.</p>

<p>3.2 USAGE POLICY</p>

<p>3.2.1 You are prohibited from endeavoring to violate the security of the Application including access to data for which you are not authorized; endeavoring to test the vulnerability of system or to breach security or confirmation measures without legitimate authorization.

<p>3.2.2 You should provide your correct and true personal information including name, email address, contact details.</p>

<p>3.2.3 You are not allowed to utilize the Application so as to transmit, disseminate, store or destroy material that could establish a criminal offence or violate any relevant law in a way that will encroach the copyright, trademark or other protected innovation privileges of others or disregard the security or exposure of other individual privileges of others or that is malicious, explicit, compromising, obscene, hateful or abusive.</p>

<p>3.2.4 You are not permitted to host, display, update or share any data which contains software viruses or any other mobile code, computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer resource.</p>


<p>3.3 CONTENT OWNERSHIP AND COPYRIGHT CONDITIONS OF ACCESS</p>

<p>3.3.1 The contents listed on the Application are (i) User generated content, or (ii) belong to Testpan. The data that is gathered by Testpan directly or indirectly from the End- Users shall belong to Testpan. Duplicating of the copyrighted content published by Testpan on the Application for any commercial purpose or to gain benefit will be an infringement of copyright and Testpan saves its privileges under applicable law accordingly.</p>

<p>3.3.2 Testpan authorizes the User to view and access the content accessible on or from the Application exclusively for ordering, accepting, conveying and communicating only as per this Agreement. The contents of the Application, data, text, graphics, pictures, logos, button symbols, software code, design, and the collection, arrangement and assembly of content on the Application (collectively, "Testpan Content"), are the property of Testpan and are protected under copyright, trademark and other laws. User shall not modify the Testpan Content or reproduce, display, publicly perform, distribute, or otherwise use the Testpan Content in any way for any public or commercial purpose or for personal gain.</p>

<p>3.3.3 User shall not access the Services for purposes of monitoring their availability, execution or functionality, or for some other benchmarking or competitive purposes.</p>

<p>3.4 REVIEWS AND FEEDBACK</p>

<p>By using this Application, you agree that any information shared by you with Testpan will be subject to our Privacy Policy.</p>

<p>You are solely responsible for the content that you choose to submit for publication on the Application, including any feedback, ratings, or reviews ("Critical Content"). The role of Testpan in publishing Critical Content is restricted to that of an 'intermediary' under the Information Technology Act, 2000. Testpan disclaims all responsibility with respect to the content of Critical Content, and its role with respect to such content is restricted to its obligations as an 'intermediary' under the said Act. Testpan shall not be liable to pay any consideration to any User for re-publishing any content across any of its platforms.</p>

<p>Your publication of reviews and feedback on the Application is governed by Clause 3.2 of these Terms. Without prejudice to the detailed terms stated in Clause 3.2, you hereby agree not to post or publish any content on the Application that (a) infringes any third-party intellectual property or publicity or privacy rights, or (b) violates any applicable law or regulation, including but not limited to the IG Rules and SPI Rules. Testpan, at its sole discretion, may choose not to publish your reviews and feedback, if so required by applicable law, and in accordance with Clause 3.2 of these Terms. You agree that Testpan may contact you through telephone, email, SMS, social media platforms or any other electronic means of communication for the purpose of obtaining feedback in relation to Application or Testpan's services and you agree to provide your fullest co-operation further to such communication by Testpan.</p> 

<p>4. TERMINATION</p>

<p>4.1 Testpan reserves the right to suspend or terminate a User's access to the Application and the Services with or without notice and to exercise any other remedy available under law, in cases where, such user breaches any terms and conditions of the agreement; an outsider reports infringement of any of its privilege because of your utilization of the Administrations; Testpan is unable to verify or authenticate any information provide to Testpan by a user; Testpan has reasonable ground for suspecting any illicit, false or abusive activity on part of such user; or Testpan believes in its sole prudence that user's activity may cause lawful obligation for such user, other users or for Testpan or are contrary to the interest of the site.</p>

<p>4.2 Once temporarily suspended, indefinitely suspended or terminated, the User may not continue to use the Application under the same account, a different account or re-register under a new account. On termination of an account due to the reasons mentioned herein, such User shall no longer have access to data, messages, files and other material kept on the Application by such User. The User shall ensure that he/she/it has continuous backup of his/her data the User has rendered in order to comply with the User's record keeping process and practices.</p>

<p>5. LIMITATION OF LIABILTY </p>

<p>Testpan or any of its directors, officers, employees, agents or content or service providers (collectively, the "Protected Entities") shall not be liable for any direct, indirect, special, incidental, consequential, exemplary or punitive damages arising from or directly or indirectly related to, the use of, or the inability to use the Application or the content, materials and functions related thereto, the services, user's provision of information via the Application, lost business or lost End-Users, even if such protected entity has been advised of the possibility of such damages. In no event, the Protected Entities shall be liable for any content which is posted, transmitted, exchanged or received by or on behalf of any user or other person on or through the Application; any unauthorized access to or alteration of your transmissions or data or any other matter relating to the Application or the service. Summing up, in no occasion, shall the total aggregate liability of the protected entities to the user for damages or losses or cause of action exceed the amount paid by user to protected entities.</p>

<p>6. RETENTION AND REMOVAL</p>

<p>Testpan may retain such information collected from users from its Application or services for as long as necessary, depending on the type of information; purpose, means and modes of usage of such information; and according to the SPI Rules. Computer web server logs may be preserved as long as administratively necessary.</p>

<p>7. APPLICABLE LAW AND DISPUTE SETTLEMENT</p>

<p>7.1 You agree that this Agreement and any contractual obligation between Testpan and User will be governed by the laws of India.</p>

<p>7.2 Any dispute, claim or controversy arising out of or relating to this Agreement, including the determination of the scope or applicability of this Agreement to arbitrate, or your use of the Application or the Services or information to which it gives access, shall be determined by arbitration in India, before a sole arbitrator appointed by Testpan. Arbitration shall be conducted in accordance with the Arbitration and Conciliation Act, 1996. The seat of such arbitration shall be Delhi. All proceedings of such arbitration, including, without limitation, any awards, shall be in the English language. The award shall be final and binding on the parties to the dispute.</p>

<p>7.3 Subject to the above Clause 6.2, the courts at Delhi shall have exclusive jurisdiction over any disputes arising out of or in relation to this Agreement, your use of the Application or the Services or the information to which it gives access.</p>

<p>8. CHANGE TO TERMS AND CONDITIONS</p>

<p>Testpan at its sole discretion may update this terms and conditions at any time. Users are required to visit this page persistently for any change to its terms and conditions. Your constant use of these services after any changes to the terms and conditions will constitute your acceptance to those changes.</p>
 
<p>9. CONTACT INFORMATION GRIEVANCE OFFICER</p>

<p>If a User has any questions concerning Testpan, the Application, this Agreement, the Services, or anything related to any of the foregoing, Testpan customer support can be reached at the following email address: admin@testpanindia.com or via the contact information available from the following hyperlink: https://testpanindia.com/ </p>

<p>10. SEVERABILITY</p>

<p>If any provision of the Agreement is held by a court of competent jurisdiction or arbitral tribunal to be unenforceable under applicable law, then such provision shall be excluded from this Agreement and the remainder of the Agreement shall be interpreted as if such provision were so excluded and shall be enforceable in accordance with its terms; provided however that, in such event, the Agreement shall be interpreted so as to give effect, to the greatest extent consistent with and permitted by applicable law, to the meaning and intention of the excluded provision as determined by such court of competent jurisdiction or arbitral tribunal.</p>


<p>11. WAIVER</p>

<p>No provision of this Agreement shall be deemed to be waived and no breach excused, unless such waiver or consent shall be in writing and signed by Testpan. Any consent by Testpan to, or a waiver by Testpan of any breach by you, whether expressed or implied, shall not constitute consent to, waiver of, or excuse for any other different or subsequent breach.</p>
</label>	</div>
   </div>
   <div class="tab__content">
      <h3>Payment Policy</h3>
         <div class="form-group col-12 col-lg-12">
    <label style="font-size:15px; color:#333">   
	The access is currently made available to you for your personal, non-commercial use, free of charge. We do not guarantee that the access to platform or any content will be free always. </label>
	</div>
    
     <div class="form-group col-12 col-lg-12">
    <label style="font-size:15px; color:#333">

<p><h3>In case of paid subscription:</h3></p>

<p>You must provide one or more payment methods to use the Testpan service. You authorize us to charge any payment method associated to your account in case your primary payment method is declined or no longer available to us for payment of your subscription fee.</p>

<p>If the payment is not successful due to the expiration or insufficient amount or otherwise or you do not cancel your account then we may suspend your access to the service until we are successfully charged a valid payment method. Local tax charges may vary depending on the Payment Method used. Check with your Payment Method service provider for details.</p>

<p>Testpan shall not be liable in any manner with respect to any loss or damage incurred directly or indirectly due to decline of authorization for any Transaction, on Account of the Cardholder having exceeded the preset limit mutually agreed by Testpan with participant bank from time to time.</p>

<p>You must not misuse the Application by knowingly introducing viruses, Trojans or any other material which is malicious or technologically harmful.</p>



</span>
<br />
<p><h3>Changes in Payment Policy </h3> </p>

<p>Testpan may at its sole discretion update the payment policy at any time. You are required to visit the page persistently for the change in payment policy and go through the payment policy before making any payment. </p>

   </div>
   </div>
   <div class="tab__content">
      <h3>Subscriber Terms & Condition</h3>
     <label style="font-size:15px; color:#333">



<p>Terms of Use for the use of BookMyTestCenter ("Application") and the other Services provided by Testpan India Private Limited ("Testpan").</p>

<p>Testpan India Private Limited ("us", "we", or "Testpan", which also includes its affiliates  is the author and publisher of the mobile application "BookMyTestCenter" ("Application")   as well as software and applications provided by Testpan, including but not limited to the mobile application. </p>

<p>These Terms of Use constitute the agreement (the "Agreement" or "Terms of Use") among Testpan and the client of Testpan's   Services ("User", as defined in Section 2 of this agreement). Your utilization of Testpan's   Services, which incorporate Application and different subordinate Services available on the Application and for which a no   sum is payable for use (hereinafter individually referred to as the " Service" and collectively referred to as the "  Services") is subject to the following terms and conditions. However, the Testpan may in the future might charge for the   services, and if any change of policy regarding   services takes place the Testpan will notify its users accordingly.</p>

<p>This Agreement is an electronic record as far as Information Technology Act, 2000 and generated by a computer framework and doesn't require any physical or computerized marks. This Agreement is distributed as per accordance of Rule 3 (1) of the Information Technology (Intermediaries rules) Rules, 2011 that require publishing the principles and guidelines, privacy policy and Terms of Use for access or use of the   Services.</p>

<p>This Agreement provides the terms and conditions for the usage of   services, primarily an android application hosted and managed remotely through the mobile application as described in section 3.9 of this agreement. The Application is owned and operated by Testpan India Private Limited.</p>




<p><strong>1. YOUR AGREEMENT WITH TESTPAN</strong></p>

<p>1.1	We reserve the right to modify the Terms of Use at any time without giving you any prior notice. Your utilization of the Services following any such alteration comprises your consent to follow and be bound by the terms of use as modified. Any additional terms and conditions, disclaimers, privacy policies and other policies applicable to general and specific areas of these Services or to specific   Services are also considered as Terms of Use. By agreeing to these terms, you also agree to the terms of utilization of the Service, which are accessible at the Application.</p>

<p>1.2	You acknowledge that you will be bound by this Agreement for availing any of the   Services offered by us.</p>

<p>1.3 Your access to use the   Services will be solely at the discretion of Testpan.</p>

<p><strong>2. WHO IS TESTPAN?</strong></p>

<p>Testpan is the author and publisher of the mobile application BookMyTestCenter and all their variants, editions, addons and additional   services or services (including all files and images contained in or generated by the software, and accompanying data, together the "Software"). The Services have been designed for use  by Private Test Centers/Labs, Engineering Colleges, Business Schools, Schools, ITI, University (collectively referred as "Institutions") engaged in conducting computer based online examination. Testpan also has a network of Online Test Terminals across India, which are used to deliver online tests. </p>
<p>Testpan makes no express or implied representations about the   services. Testpan does not authorise anyone to make a warranty on Testpan's behalf and you may not rely on any statement of warranty as a warranty by Testpan. All users of the Services are together termed as ("Users"or "you" or "your").</p>

 <p><strong>3. TERMS OF USE</strong></p>

<p>3.1 By utilizing the Services, you agree that you have read and understood these Terms of Use and you consent to be bound by these Terms of Use and utilize these   Services in consistence with these Terms of Use. PLEASE READ THESE TERMS OF USE CAREFULLY. IN THE EVENT THAT YOU DO NOT AGREE TO BE BOUND BY (OR CANNOT COMPLY WITH) ANY OF THE TERMS BELOW, DO NOT CLICK/SIGN THE "I AGREE" BOX, DO NOT COMPLETE THE REGISTRATION PROCESS, AND DO NOT ATTEMPT TO USE THE SERVICE. You explicitly represent and warrant that you won't utilize these   Services in the event that you do not understand, consent to become a party to, and abide by all of the terms and conditions specified below. Any violation of these Terms of Use may result in legal liability upon you. Nothing in these Terms of Use should be construed to confer any rights to any third party or any other person. YOUR USE OF THE APPLICATION MEANS YOU ARE CONSENTING TO THIS AGREEMENT.</p>

<p>3.2 The Agreement is published in compliance of, and is governed by the provisions of Indian law, including but limited to:</p>

<p>3.2.1 The Indian Contract Act, 1872,</p>

<p>3.2.2 The (Indian) Information Technology Act, 2000, and</p>

<p>3.2.3 The rules, regulations, guidelines and clarifications framed thereunder, including the (Indian) Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Information) Rules, 2011 (the "SPI Rules"), and the (Indian) Information Technology (Intermediaries Guidelines) Rules, 2011 (the "IG Rules").</p>

<p>3.3 Testpan provides a condition to users for the use and access to the   Services that is User's acceptance of this Agreement. If a user does not agree with any provision of the same, such user is required to leave this computer resource/ the services immediately and immediately discontinue use of all   Services available at the Testpan.</p>

<p>3.4 Testpan authorises the User to view and access the content available on the   Services solely for booking, delivering and communicating only as per this Agreement. The contents of the   Services, information, text, graphics, images, logos, button icons, software code, design, and the collection, arrangement and assembly of content on the Services (collectively, "Testpan Content"), are the property of Testpan and are protected under copyright, trademark and other laws. User is not permitted to modify the Testpan Content or reproduce, display, publicly perform, distribute, or otherwise use the Testpan Content in any way for any public or commercial purpose or for personal gain.</p>

<p>3.5 Multiple Users are not permitted to share the same/single login. </p>

<p>3.6 If you are a student, associate, consultant, intern or are in any way associated with the Institutions that has subscribed to the Services and the subscribing Institution has authorised you, explicitly or implicitly, to use the Services, this Agreement is a three way agreement between you, the Institution and Testpan. Both the Institute and Testpan may seek recourse against you for any violation of the terms of this Agreement.</p>

<p>3.7 Users may not transfer (including by way of sublicense, lease, assignment or other transfer, including by operation of law) their login or right to utilize the   Services to any third party. You, the User, are exclusively responsible for the manner in which anyone you have authorised to utilize the Services and for ensuring that all of such Users comply with all of the terms and conditions of this Agreement. Any violation of the terms and/or conditions of this Agreement by any such User shall be deemed to be a violation thereof by you.</p>

<p>3.8 These Terms of Use will also be applicable to Users who access Application features using native mobile applications published by Testpan including but not limited to its applications for devices running on platforms such as iOS, Android, Windows, and any derivatives or any other platforms. Additional terms of use may be applicable to Users while accessing Software using such mobile applications.</p>

<p>3.9 You agree that any registration information you give to Testpan will always be true, accurate, correct, complete and up to date, to our knowledge. Any phone number used to register with the Services be registered in your name and you might be asked to provide supporting documents to prove the same.</p>

<p>3.10 You agree that you will not use the Services provided by Testpan for any unauthorised and unlawful purpose. </p>

<p>3.11 You agree to use the   Services only for purposes that are permitted by (a) the Terms of Use and (b) any applicable law, regulation and generally accepted practices or guidelines in the relevant jurisdictions (including any laws regarding the export of data or software to and from India or other relevant countries).</p>

<p>3.12 You agree not to access (or attempt to access) any of the Services by any means other than through the interface that is provided by Testpan, unless you have been specifically allowed to do so in a separate agreement with Testpan.</p>

<p>3.13 You agree that you will not engage in any activity that interferes with or disrupts the   Services (or the servers and networks which are connected to the Services).</p>

<p>3.14 You agree that you will not reproduce, duplicate, copy, transfer, license, rent, sell, trade or resell the Software or any other Services for any purpose whatsoever.</p>

<p>3.15 You agree that you are solely responsible for (and that Testpan has no responsibility to you or to any third party for) any breach of your obligations under the Terms of Use and for the consequences (including any loss or damage which Testpan may suffer) of any such breach.</p>

<p>3.16 You shall indemnify Testpan for any claims, losses or damages, or for the costs of any regulatory or court proceedings suffered by Testpan as a result of your breach under any applicable law.</p>

<p>3.17 You expressly acknowledge and agree that your use of the Services is at your sole risk and that the   Services are provided "as is" and "as available".</p>

<p>3.18 You agree that you will not make any unsolicited calls or use any information displayed on the Testpan, an online platform; to breach any applicable rules and guidelines related to unsolicited commercial communications, including but not limited to regulations & guidelines such as TRAI guidelines for telemarketers, or otherwise violate applicable law while using the Services.</p>

<p>3.19 You agree that this Agreement and the Services of Testpan are subject to any modification, or may be removed by Testpan, as a result of change in government regulations, policies and local laws as applicable.</p>

<p>3.20 You agree and understand that you are responsible for maintaining the confidentiality of passwords associated with any login you use to access the Application.</p>

<p>3.21 Your use of each Service confers upon you only the rights and obligations relating to such   Service, and not to any other Service or service that may be provided by Testpan. For instance, being a subscriber to BookMyTestCenter does not automatically entitle you to a higher ranking on Testpan's Institution search facility.</p>

<p><strong>4. Use of   Services</strong></p>

<p>4.1 Testpan provides Application through Google Play (Android) & App Store (iOS). Testpan is not responsible for and does not deal with any consumer managed by User through the native mobile applications and only provides access of the Application to User through Google Play (Android) & App Store (iOS). </p>

<p>       Testpan does not transfer either the title or the intellectual property rights to the Application and other its   Services, and Testpan (or its licensors) retain full and complete title to the Application as well as all intellectual property rights therein. User agrees to use the Services and the materials provided therein only for purposes that are permitted by: (a) this Agreement; and (b) any applicable law, regulation or generally accepted practices or guidelines in the relevant jurisdictions. Information provided by a User to Testpan may be used, stored or republished by Testpan or its affiliates even after the termination of these Terms of Service.</p>

<p>4.2 Testpan offers its Services on as is basis and has the sole right to modify any feature or customise them at its discretion and there shall be no obligation to honour customisation requests of any User. </p>

<p>4.3 User shall not access the Services of Testpan if the User or the organisation that he/she/it represents is Testpan's direct competitor, except with Testpan's prior written consent. In addition, the User shall not access the   Services for purposes of monitoring their availability, performance or functionality, or for any other benchmarking or competitive purposes.</p>

<p>4.4 Testpan provides, at its discretion basic support for the Services at no additional charge, and/or upgraded support if purchased separately and will use commercially reasonable efforts to make the   Services available 24 hours a day, 7 days a week, except for (i) planned downtime (of which Testpan shall give at least 8 hours' notice to Users via the   Services and which Testpan shall schedule to the extent practicable during the weekend hours from 6:00 p.m. Indian Standard Time (IST) Friday to 6:00 a.m. Indian Standard Time (IST) Monday), or (ii) any unavailability caused by circumstances beyond Testpan's reasonable control, including without limitation, acts of God, acts of government, flood, fire, earthquakes, civil unrest, acts of terror, strikes or other labour problems, or internet service provider failures or delays. Testpan will provide the   Services only in accordance with applicable laws and government regulations.</p>

<p>4.5 Notwithstanding anything to the contrary contained herein, Testpan does not warrant that its   Services will always function without disruptions, delay or errors. A number of factors may impact the use of the   Services (depending on the   Services used) and native mobile applications and may result in the failure of your communications including but not limited to: your local network, firewall, your internet service provider, the public internet, your power supply and telephony services. Testpan takes no responsibility for any disruption, interruption or delay caused by any failure or inadequacy in any of these items or any other items over which we have no control.</p>

<p>4.6 In the event the Services are not available due to apparent default at Testpan's end or are rendered unusable, Testpan may at its discretion extend the Service period of the Institution only by such number of calendar days when the   Services were not available. However, you shall agree that Testpan is not responsible and will not be held liable for any failure of intermediary services such as internet connectivity failure or telephonic disconnections.</p>

<p>4.7 The   Services may be subject to certain limitations, such as limits on disk storage space, on the number of calls Users are permitted to make against Testpan's application programming interface, and other limitations dependent on the 'User Plan', for example, number of SMS, number of bookings, number of users or accounts, validity of Services and any other limitations. Any such limitations are specified in the User Plans. The   Services have been designed to provide real time information to enable User to monitor such User's compliance with such limitations.</p>

<p>4.8 Notwithstanding anything to the contrary contained herein, Institution alone shall be liable for Institution's dealings and interaction with consumer, his/her representatives or affiliates, searching for Institution through the Application (the "EndUser") contacted or managed through the Application and Testpan shall have no liability or responsibility in this regard. Testpan does not guarantee or make any representation with respect to the correctness, completeness or accuracy of the information or detail provided by End-Users or any third party through the   Services. </p>

<p>4.9 Testpan may, at its sole discretion, suspend User's ability to use or access the   Services at any time while Testpan investigates complaints or alleged violations of this Agreement, or for any other reason.</p>

<p>4.10 Testpan reserves the right to use all information captured in its   Services in anonymous form for the purpose of its   Services improvements, and providing analytics and business intelligence to third parties. On the basis of such information, Testpan tries to make its   Services more useful in following way:</p>
<li>User will get preloaded test center data where mentioned your registered number in test center database.</li>
<li>User can change/edit demography of your preloaded test center & upload photographs with geo-tag (Current Address + Current Date + Current Time).</li>
<li>User can add new test center & upload photographs with geo-tag (Current Address + Current Date + Current Time).</li>
<li>If user will change or update data of preloaded or new test center (new test center initially user was added through app), TESTPAN team will start the verification process and user can view status in my center page (Submitted/Verification in progress/Approved).  </li>
<li>Manage here your project of other client with our app & we will notify to user according to availability of dates and seats of test center.</li>
<li>Book here your test center through app of TESTPAN upcoming projects.</li>
<li>User can view projects updation (Seats, batches and exam dates), which was booked by TESTPAN only. </li>
<li>User can give feedback in contact US page.</li>
<li>Users can use the rectification tools provided by Testpan or contact Testpan immediately for rectifications. Testpan shall bear no liability or responsibility in this regard.</li>

<p>4.11 Testpan reserves the right to use the following types of information stored in our Application / software:</p>
<li>Institution information</li>
<li>End-Users demographic information as anonymised form</li>
<li>End-Users information in relation to the exam (anonymised form).</li>

<p>4.12 Testpan automatically starts the verification process if the user opts for the change of Institution and accordingly notifies the user regarding the available seats and dates of Institution. Testpan on its own, does not list any Personally Sensitive Information of such Institutions and users. Testpan reserves the right to list Institutions who are not a party to this Agreement and the Institutions who have subscribed to this Terms of Use are listed along with them. Thereon, Testpan reserves the right to modify the listing of Institutions on its Applications.</p> 


<p>4.13 The Services available by Testpan accepts online booking requests for all Institution listed and displayed on its Application. Testpan intends to take all reasonable steps to duly inform the test centers via phone and email for booking requests made on thorugh Application. However, it is possible that some booking requests do not reach the center in a timely manner due to technical or operational reasons including but not limited to cases when test center do not respond to phone calls made by Testpan or when test centers do not read email or text messages sent by Testpan in timely manner. Testpan shall have no liabilty or responsibility in this regard.</p>
      

<p>4.14 While Testpan makes every possible effort to ensure a confirmed booking for an EndUser who requested a booking on the Service, Testpan does not guarantee that bookings will be confirmed in all cases. Further, Testpan has no liability if such booking is confirmed but later cancelled by any of the End-Users, or the Institution is not available as per the given time.</p>

<p>4.15 Certain   Services (including ancillary Services) may be subject to additional limitations, restrictions, terms and/or conditions specific to such Software ("Specific Terms"). In such cases, the applicable Specific Terms will be and your access to and use of the relevant Services will be contingent upon your acceptance of and compliance with such Specific Terms.</p>

<p>4.16 Testpan reserves the right to add new functionality, remove existing functionality, and modify existing functionality to its Services as and when it deems fit, and make any such changes available in newer versions of its Services or native mobile application or all of these at its discretion. All Users of its   Services will be duly notified upon release of such newer versions and Testpan reserves the right to automatically upgrade all Users to the latest version of its Software as and when it deems fit.</p>

<p>4.17 BookMyTestCenter Terms of Use:</p>

<p>4.17.1The Institution agrees that if the Application is being used by its employees or agents, including receptionists, such employees or agents will use the Application in accordance with this Agreement.</p>

<p>4.17.2User can use BookMyTestCenter to book Test Center with End-Users, send End-Users reminders for booking, and record their data.</p>

<p>4.17.3BookMyTestCenter being an ancillary product of Testpan, the reviews and recommendations shared over BookMyTestCenter can be also displayed on the Application. Reviews and recommendations of the End-Users not registered with Testpan may be displayed on the Application through BookMyTestCenter. User agrees that Testpan shall not be responsible for any of the reviews made on the Application.</p>

<p>4.17.4 Testpan reserves the right to make any further operational changes to the Application, at its discretion and the Institutions will be notified of such changes or updates with a prior notice. The extension or withdrawal of such facility shall be intimated to you by Testpan.</p>

<p>4.17.5 User shall agree that they will be subscribing to the Application for the purpose of EndUser management and will not use the   Services provided by Testpan for any unauthorized and unlawful purpose. You will not impersonate another person.</p>

<p>4.17.6 User shall agree that you will indemnify and keep indemnified Testpan for all costs, damages and losses in case of any breach of security procedures by the User(s), User's employees or its vendors.</p>

<p>4.17.7 Any communication sent by or through Testpan to the clients or customers (whether or not End-Users) of a particular Institution is based solely on information uploaded by such Institute on the BookMyTestCenter software. The accuracy and completeness of such information (including but not limited to contact details of the client or customer) is the sole responsibility of the Institute. Testpan will not be responsible for the incompleteness or inaccuracy such information, including if as a result of such inaccuracy, a communication is sent to an unintended recipient.</p>

<p>4.17.8 Testpan may add new Services for additional fees and charges for existing   Services, at any time in its sole discretion. Fees if at any point of time made applicable  for the   Services being provided, may be amended  at Testpan's sole discretion from time to time, shall apply. The   fees if applicable at any stage, may be non-refundable.</p>

<p>4.17.9 You agree that the billing credentials provided by you for any booking from Testpan will be accurate and you shall not use billing credentials that are not lawfully owned by you.</p>

<p>4.17.10 Testpan in future may make available an offline fee payment facility, supported by a third party vendor. Testpan is not responsible for any loss or damage caused to the User using this payment facility provided by such third party vendor.</p>

<p>4.19 Testpan reserves the right to modify the fee structure by providing a 30 (thirty) days' prior notice, either by notice on the   Services or through email to the authorized User, which shall be considered as valid and agreed communication. Upon the User not communicating any response to Testpan to such notice, Testpan shall apply the modified fee structure effective from the expiry of the said notice period. This clause would be applicable after Testpan imposes fee structure for its services.</p>

<p>4.20 In order to process the fee payments, Testpan might require details of User's bank account, credit card number and other such financial information. Users are directed to check our privacy policy on how Testpan uses the confidential information provided by Users.</p>

<p>4.21 Notwithstanding anything to the contrary contained herein, in case the payments are made by a User through credit card, an invoice for subsequent period/renewals shall be generated 10 (ten) days prior to the expiry of the existing   period and an email will be sent to such User registered with Testpan intimating such User about expiration of the current service period and that the credit card of such User registered with Testpan  will be charged automatically against payment of service fee for subsequent   period, along with a copy of the invoice for the subsequent   period/renewal. Subject to the provisions of section 8.2 below, if a User is not willing to continue or renew the period of Services, the same shall be communicated to Testpan of such intimation to discontinue the services, Testpan shall be entitled to charge the credit card of the User registered with Testpan on the day the current   period expires. This clause would be applicable after Testpan imposes fee structure for its services.</p>


<p>4.22 Testpan shall send an intimation of receipt of fee (if applicable) from the Users through an email within 7 (seven) working days of receipt of fee into Testpan's designated bank account.</p>

<p>4.23 In case of nonpayment of any fee beyond the date a payment becomes overdue (overdue date), Testpan reserves the right to take any or all of the following actions as it deems appropriate (i)reduce all   Service credits in Users' Services account to 0 (zero) anytime after 7 (seven) days from the overdue date, including but not limited to SMS and Call credits. (ii)discontinue the   Services to the User any time after 30 (thirty) days from the overdue date. (iii) delete all information in User's account any time after 90 (ninety) days from the overdue date. This clause would be applicable after Testpan imposes fee structure for its services.</p>


<p>4.24 Fees and charges shall be calculated solely based on records maintained by Testpan or its third party billing provider. No other information of any kind shall be acceptable by us or have any effect under this agreement. Decision of Testpan shall be final and binding in relation to any fees payable by Users. This clause would be applicable after Testpan imposes fee structure for its services.</p>


<p>4.25 You can cancel your access to the Services by contacting our customer support by email at admin@testpanindia.com. The one time setup fees shall not be refunded to the User.</p>

<p>4.26 Testpan will not be liable to you or to any third party for any modification, suspension, or discontinuance of the   Services, or parts thereof, except that you are only entitled to a prorated refund representing the unused (as of the date of termination) portion of any fees (if applicable), paid deposits or payments for   Services other than the nonrefundable one time setup fees as due prior to permanent discontinuation the   Services or upon the expiry of 45 (forty five) days from the date of your written notice to Testpan. Testpan shall have the right to deduct any taxes that are due in relation to the refund amount (if any). The   fees are non transferables and the payment made by the User for a particular   Service cannot be transferred or carried over to another Service.</p>


<p><strong>5. Collection, Use, Storage and Transfer of Personal Information</strong></p>

<p>5.1 The terms "personal information" and "sensitive personal data or information" are defined under the SPI Rules, and are reproduced in the privacy policy ("Privacy Policy") available in this Application.</p>

<p><strong>6. Covenants</strong></p>

<p>6.1 As mandated by Regulation 3(2) of the IG Rules, Testpan hereby informs the User that the User is not permitted to host, display, upload, modify, publish, transmit, update or share any information that:</p>
<li>Belongs to another person and to which the User does not have any right to</li>
<li>Is grossly harmful, harassing, blasphemous, defamatory, obscene, pornographic, paedophilic, libellous, invasive of another's privacy, hateful, or racially, ethnically objectionable, disparaging, relating or encouraging money laundering or gambling, or otherwise unlawful in any manner whatever</li>
<li>Harm minors in any way</li>
<li>Infringes any patent, trademark, copyright or other proprietary rights</li>
<li>Violates any law for the time being in force</li>
<li>Deceives or misleads the addressee (or EndUser or User) about the origin of such messages or communicates any information which is grossly offensive or menacing in nature</li>
<li>Impersonate another person</li>
<li>Contains software viruses or any other computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer resource</li>
<li>Threatens the unity, integrity, defence, security or sovereignty of India, friendly relations with foreign states, or public order or causes incitement to the commission of any cognisable offence or prevents investigation of any offence or is insulting any other nation.</li>

<p>6.2 The User is also prohibited from:</p>
<li>Violating or attempting to violate the integrity or security of the   Services or any Testpan Application / Software</li>
<li>Transmitting any information (including job posts, messages and hyperlinks) on or through the   Services that is disruptive or competitive to the provision of   Services byTestpan</li>
<li>Intentionally submitting on the Services any incomplete, false or inaccurate information</li>
<li>Making any unsolicited communications to other Users</li>
<li>Using any engine, software, tools, agent or other device or mechanism (such as spiders, robots, avatars or intelligent agents) to navigate or search the Service</li>
<li>Attempting to decipher, decompile, disassemble or reverse engineer any part of the   Services unless explicitly permitted by Testpan</li>
<li>Copying or duplicating in any manner any of the Testpan content or other information available from the Service</li>
<li>Framing or hotlinking or deep linking any Testpan content</li>
<li>Circumventing or disabling any digital rights management, usage rules, or other security features of the Software</li>

<p>6.3 Testpan, upon obtaining knowledge by itself or being brought to actual knowledge by an affected person in writing or through email signed with electronic signature about any such information as mentioned in Section 6.2 above, shall be entitled to disable such information that is in contravention of Section 6.2. Testpan shall be entitled to preserve such information and associated records for at least 90 (ninety) days for service on to governmental or investigative authorities for investigation purposes.</p>

<p>6.4 In case of noncompliance with any applicable laws, rules or regulations, or the Agreement (including the privacy policy) by a User, Testpan has the right to immediately terminate the access or usage rights of the User to the   Services and to remove non-compliant information.</p>

<p>6.5 Testpan may disclose or transfer User Information (as defined in the privacy policy) to its affiliates, and you hereby consent to such transfer. The SPI Rules only permit Testpan to transfer sensitive personal data or information including any information, to any other body corporate or a person in India, or located in any other country, that ensures the same level of data protection that is adhered to by Testpan as provided for under the SPI Rules, only if such transfer is necessary for the performance of the lawful contract between Testpan or any person on its behalf and the user or where the User has consented to data transfer.</p>

<p>6.6 Testpan respects the intellectual property rights of others and we do not hold any responsibility for any violations of any intellectual property rights.</p>

<p><strong>7. Liability</strong></p>

<p>7.1 Testpan shall not be responsible or liable in any manner to the Users for any losses, damages, injuries or costs incurred by the Users as a result of any disclosures made by Testpan, where the User has consented to the making of disclosures by Testpan. If the User had denied such consent under the terms of the privacy policy, then Testpan shall not be responsible or liable in any manner to the User for any losses, damages, injuries or expenses incurred by the User as a result of any disclosures made by Testpan prior to its actual receipt of such revocation.</p>

<p>7.2 The User shall not hold Testpan responsible or liable in any way for any disclosures by Testpan under Regulation 6 of the SPI Rules.</p>

<p>7.3 Testpan shall not be liable for ways in which EndUser data is used by Institutions, and other authorized users of Software at a Practice. It is the responsibility of the Test Center alone to ensure that the EndUser data either stored in Software or taken out from Software by printing or exporting to PDF, CSV or any other computer file format or data stored offline in mobile devices of users accessing Software through mobile applications published by Testpan, is used in compliance to local privacy laws applicable.</p>
 
<p>7.4 The   Services of Testpan may be linked to the services of third parties, affiliates and business partners. Testpan has no control over, and not liable or responsible for content, accuracy, validity, reliability, quality of such   Services or made available by/through our Services. Inclusion of any link on the   Services does not imply that Testpan endorses the linked site. User may use the links and these   Services at User's own risk.</p>

<p>7.5 Testpan shall not be liable for any damages to, or viruses that may infect User's equipment on account of User's access to, use of, or browsing the Services or the downloading of any material, data, text, images, from the Service. If a User is dissatisfied with the Service, User's sole remedy is to discontinue using the Testpan's   Services.</p>

<p>7.6 The Services may enable User to communicate with other Users or to post information to be accessed by others, whereupon other Users may collect such data. Such Users, including any moderators or administrators, are not authorized Testpan representatives or agents, and their opinions or statements do not necessarily reflect those of Testpan, and they are not authorized to bind Testpan to any contract. Testpan hereby expressly disclaims any liability for any reliance or misuse of such information that is made available by Users or visitors in such a manner.</p>

<p>7.7 Testpan or any of its directors, officers, employees, agents or content or service providers (collectively, the "protected entities") shall not be liable for any direct, indirect, special, incidental, consequential, exemplary or punitive damages arising from, or directly or indirectly related to the use of   services or the content, materials and functions related thereto, User's provision of information via the   Services of the Testpan, lost business or lost sales, even if such protected entity has been advised of the possibility of such damages.  In no event shall the total aggregate liability of the protected entities to the user for damages or losses or cause of action exceed the amount paid by user to protected entities.</p>

<p>7.8 In no event shall the protected entities be liable for failure on the part of the Users to provide agreed   Services. In no event shall the protected entities be liable for any comments or feedback given by any of the Users in relation to the   Services provided by a User.</p>

<p>7.9 The listing order of Institutions on the Services is based on numerous factors including End-Users' comments and feedback. In no event shall the protected entities and the Testpan be liable or responsible for the listing order of Institutions on the Service. Further, Testpan shall not be responsible for adverse feedback or comments, or ratings on the   Services which are a subject matter of automated processes, and Testpan disclaims any liability for lost business or reputation of a User due to information, data or ratings that are available on the Service. Testpan at its discretion hold the sole right to display the listing order of the Institutions.</p>

<p>7.10 The reviews and the feedbacks are displayed by the Testpan at its discretion. You agree that Testpan may contact you through telephone, email, sms, social media platforms or at your contact details for the limited purpose of:</p>
     <p> Obtaining feedback in relation to Testpan's Services and/or</p>
    <p>  Obtaining feedback in relation to any Institution. </p>

<p><strong>8. Indemnity</strong></p>

<p>User consent to indemnify and hold innocuous, without opposition, Testpan, its officials, executives, workers and operators from and against any claims, activities as well as requests as well as liabilities or potentially misfortunes or potentially harms emerging from or resulting from their utilization of  and use of the Application  or their breach of the terms.</p>

<p><strong>9. Spamming</strong></p>

<p>Testpan has a zero tolerance spam policy. Testpan employs controls on user permission to receive Content from Testpan's Services and has easily accessible ways for users to block or not receive content if they chose to. However, Testpan's policy on spam is clearly stated below:
Spamming is defined as the practice of (i) sending unsolicited messages, likely with commercial content, (ii) in large quantities (iii) to an indiscriminate set of recipients. The result of this practice is termed "Spam".</p>
<p>The sender of any message deemed to be "spam" is liable for Rs. 5,000/ for each EndUser that receives each unauthorized message. The sender of 'Spam' will pay all fees owed to Testpan within thirty (30) days of such transmission.</p>

<p><strong>10. Term, Termination and Disputes</strong></p>

<p>10.1 Testpan reserves the right to suspend or terminate a User's access to the Application and the Services with or without notice and to exercise any other remedy available under law, in cases where such user breaches any terms and conditions of the agreement; an outsider reports infringement of any of its privilege because of your utilization of the Administrations; Testpan is unable to verify or authenticate any information provided to Testpan by a user; Testpan has reasonable grounds for suspecting any illicit, false or abusive activity on the part of such user; or Testpan believes in its sole prudence that user's activity may cause lawful obligation for such user, other users or for Testpan or are contrary to the interest of the site.</p>

<p>10.2 Once temporarily suspended, indefinitely suspended or terminated, the User may not continue to use the Application under the same account, a different account or re-register under a new account. On termination of an account due to the reasons mentioned herein, such User shall no longer have access to data, messages, files and other material kept on the Application by such User. The User shall ensure that he/she/it has continuous backup of his/her data the User has rendered in order to comply with the User's record keeping process and practices.</p>

<p>10.3 Return of User's Data: Upon request by a User made within 30 (thirty) days after the effective date of termination of a   Services  , Testpan will make available to the User for download a copy of such User's data in comma separated value (csv) format or any other format as determined by Testpan. After such 30 (thirty) days period, Testpan shall have no obligation to maintain or provide any of such User's data and shall thereafter, unless legally prohibited, delete all User's data in its systems or otherwise in its possession or under its control. In cases where User terminates the   voluntarily, it will be the sole responsibility of the User to make a copy of their data before terminating the   Users data will not be available after termination of services in such cases.</p>

<p>10.4 This Agreement and any contractual obligation between Testpan and User will be governed by the laws of India, subject to the exclusive jurisdiction of Courts in Noida, India.</p>

<p>10.5 Even after termination, certain obligations mentioned under Covenants, Liability, Indemnity, Intellectual Property, Dispute Resolution will continue and survive termination.</p>

<p>10.6 Any amendment in these Terms shall replace all previous versions of the same.</p>

<p><strong>11. Theft of   services</strong></p>

<p>If the content of the user is stolen or it came to the knowledge of the user that his/her account with the   service is being misused or being used fraudulently, then the user agrees to notify Testpan immediately in writing or by mail to admin@testpanindia.com or by calling Testpan customer care on 011-28520481. User must provide the account details and detailed description of the circumstances of the theft or fraudulent use of the   services while calling or mailing Testpan. User will be liable for all use of the Services if his/her account is misused and also for any and all stolen services or fraudulent use of the service. Testpan shall not be liable to extend the service period or waive off any fees on account of such theft or fraudulent use. This includes, but is not limited to, modem hijacking, wireless hijacking, or other fraud arising out of a failure of your internal or corporate security procedures. </p>

<p><strong>12. Misuse of   services</strong></p>

<p>Testpan may restrict, suspend or terminate the account of any User who abuses or misuses the   Services. Misuse includes creating multiple or false profiles, infringing any intellectual property rights, violating any of the terms and conditions of these Terms of Use, or any other behavior that Testpan, in its sole discretion, deems contrary to its purpose. In addition, and without limiting the foregoing, Testpan has adopted a policy of terminating accounts of users who, in Testpan's sole discretion, are deemed to be repeat infringers of any Terms of Use even after being warned by Testpan.</p>

<p><strong>13. Severability and Waiver</strong></p>

<p>If any provision of this Terms of Use is held to be invalid or unenforceable, such provision shall be struck and the remaining provisions shall be enforced.</p>

<p><strong>14. Contact Information</strong></p>
<p>If a User has any question concerning Testpan, Services, the Service, this Agreement, please contact our customer support at the following email address: admin@testpanindia.com or via the contact information available from the following hyperlink: https://testpanindia.com/ .</p>

</span>

   </div>
</div>