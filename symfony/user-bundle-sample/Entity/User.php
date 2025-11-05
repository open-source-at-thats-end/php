<?php
/**
 * Created by PhpStorm.
 * User: m.benhenda
 * Date: 09/07/2015
 * Time: 02:28
 */
namespace CAB\UserBundle\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use CAB\CourseBundle\Entity\VehiculeAffect;
use CAB\CourseBundle\Entity\Rating;
use CAB\CourseBundle\Entity\Zone;
use Hackzilla\Bundle\TicketBundle\Model\UserInterface as ticketInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="cab_fos_user")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="CAB\UserBundle\Entity\UserRepository")
 * @UniqueEntity("email")
 * @ExclusionPolicy("all")
 * @Vich\Uploadable
 */
class User extends BaseUser implements ParticipantInterface, ticketInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"Public"})
     * @Expose
     */
    protected $id;

    /**
     * @var string $paymentId
     * @ORM\Column(type="string", nullable=true)
     */
    protected $paymentId;

    /**
     * @var string $firstName
     * @ORM\Column(type="string", name="first_name", nullable=false, unique=false)
     * @Assert\NotBlank(message = "not.blank.firstname")
     * @Groups({"Public"})
     * @Expose
     */
    protected $firstName;

    /**
     * @var string $lastName
     * @ORM\Column(type="string", name="last_name", nullable=false, unique=false)
     * @Assert\NotBlank(message = "not.blank.lastname")
     * @Groups({"Public"})
     * @Expose
     */
    protected $lastName;

    /**
     * @var string
     * @Assert\NotBlank(message = "not.blank.email")
     * @Expose
     */
    protected $email;

    /**
     * @var boolean $isCompany
     *
     * @ORM\Column(name="is_company", type="boolean", nullable=true)
     */
    protected $isCompany;

    /**
     * @var string
     * @ORM\Column(name="name_company", type="string", nullable=true)
     */
    protected $nameCompany;

    /**
     * @var string
     * @ORM\Column(name="siren", type="string", nullable=true)
     */
    protected $siren;

    /**
     * @var string
     * @ORM\Column(name="phone_company", type="string", nullable=true)
     * @Expose
     */
    protected $phoneCompany;

    /**
     * @var string $sexe
     *
     * @ORM\Column(name="sexe", type="string", nullable=true)
     */
    protected $sexe;

    /**
     * @var boolean $isHandicap
     *
     * @ORM\Column(name="is_handicap", type="boolean", nullable=true)
     */
    protected $isHandicap;

    /**
     * @ORM\OneToOne(targetEntity="CAB\CourseBundle\Entity\OptionsHandicap", inversedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $optionsHandicap;

    /**
     * @var boolean $privateNote
     *
     * @ORM\Column(name="private_note", type="text", nullable=true)
     */
    protected $privateNote;

    /**
     * @var boolean $publicNote
     *
     * @ORM\Column(name="public_note", type="text", nullable=true)
     */
    protected $publicNote;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *  @Assert\NotBlank(message = "not.blank.address")
     * @Expose
     * @Groups({"Details"})
     */
    private $address = null;

    /**
     * @var string $addressComplement
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"Details"})
     */
    private $addressComplement = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"Details"})
     */
    private $city = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Expose
     * @Groups({"Details"})
     */
    private $postCode = null;

    /**
     * @ORM\Column(type="string", columnDefinition="CHAR(2)", nullable=true)
     * @Expose
     * @Groups({"Details"})
     */
    private $country = null;

    /**
     * @ORM\Column(name="phone_mobile", type="string", length=20, nullable=true, unique=true)
     * @Expose
     * @Groups({"Details"})
     */
    private $phoneMobile = null;

    /**
     * @ORM\Column(name="phone_home", type="string", length=20, nullable=true)
     * @Expose
     * @Groups({"Details"})
     */
    private $phoneHome = null;

    /**
     * @ORM\Column(name="phone_work", type="string", length=20, nullable=true)
     * @Expose
     * @Groups({"Details"})
     */
    private $phoneWork = null;

    /**
     * @var datetime $birthday
     * @Assert\DateTime()
     * @ORM\Column(type="datetime", name="birthday", nullable=true)
     */
    private $birthday;

    /**
     * @var boolean $nightWorkingDriver
     *
     * @ORM\Column(name="nightWorkingDriver", type="boolean", nullable=true)
     */
    protected $nightWorkingDriver;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     * @Groups({"Files", "Avatar"})
     */
    private $avatar = null;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @ORM\Column(type="string",length=250, name="driving_license", nullable=true)
     * @Groups({"Files"})
     */
    private $drivingLicense = null;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $docDl;

    /**
     * @ORM\Column(type="string",length=250, name="medical_examination", nullable=true)
     * @Groups({"Files"})
     */
    private $medicalExamination = null;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $docMe;

    /**
     * @ORM\Column(type="string",length=250, name="piece_identity", nullable=true)
     * @Groups({"Files"})
     */
    private $pieceIdentity = null;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $docPi;

    /**
     * @ORM\Column(type="string",length=250, name="locker_judiciare", nullable=true)
     * @Groups({"Files"})
     */
    private $lockerJudiciare = null;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $docLj;

    /**
     * @ORM\OneToMany(targetEntity="\CAB\CourseBundle\Entity\Company", mappedBy="contact")
     * @ORM\OrderBy({"id" = "ASC"})
     * @Expose
     * @Groups({"Private"})
     *
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="\CAB\CourseBundle\Entity\Device", mappedBy="user", cascade={"persist", "remove"})
     *
     */
    private $devices;

    /**
     * @ORM\ManyToOne(targetEntity="CAB\CourseBundle\Entity\Company", inversedBy="users")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Groups({"User"})
     */
    private $driverCompany;

    /**
     * @ORM\ManyToOne(targetEntity="CAB\CourseBundle\Entity\Company", inversedBy="companyAgents")
     * @ORM\JoinColumn(name="agent_company_id", referencedColumnName="id")
     * @Expose
     * @Groups({"Private"})
     */
    private $agentCompany;

    /**
     * @ORM\OneToOne(targetEntity="CAB\CourseBundle\Entity\Company", inversedBy="businessUser" ,cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", name="business_company_id", )
     */
    private $businessCompany;

    /**
     * Only for clients of business company
     * @var boolean $isCredit
     *
     * @ORM\Column(name="is_credit", type="boolean", nullable=true)
     */
    private $isCredit;

    /**
     * @ORM\ManyToOne(targetEntity="CAB\CourseBundle\Entity\Company", inversedBy="companyCustomers")
     * @ORM\JoinColumn(name="customer_company_id", referencedColumnName="id")
     */
    private $customerCompany;
    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\Course", mappedBy="client", cascade={"persist", "remove"})
     * @ORM\OrderBy({"departureDate" = "DESC"})
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\Course", mappedBy="createdBy", cascade={"remove"})
     */
    private $courseCreator;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\Course", mappedBy="driver", cascade={"remove"})
     */
    private $courseDriver;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\Course", mappedBy="driverBack", cascade={"remove"})
     */
    private $courseDriverBack;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\Geolocation", mappedBy="driver", cascade={"remove"})
     */
    private $geolocationDriver;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\PaymentCard", mappedBy="user", cascade={"remove"})
     */
    private $paymentCards;

    /**
     * @ORM\OneToOne(targetEntity="CAB\CourseBundle\Entity\Vehicule", mappedBy="driver")
     */
    private $vehicle;

    /**
     * @ORM\OneToOne(targetEntity="CAB\CourseBundle\Entity\DriverWorkDays", mappedBy="driverDay", cascade={"persist", "remove"})
     */
    private $driverWorkDay;

    /**
     * @ORM\OneToOne(targetEntity="CAB\CourseBundle\Entity\DriverWorkNight", mappedBy="driverNight", cascade={"persist", "remove"})
     */
    private $driverWorkNight;

    /**
     * @ORM\ManyToMany(targetEntity="CAB\CourseBundle\Entity\Zone", inversedBy="users")
     * @ORM\JoinTable(name="cab_zones_users")
     */
    private $zones;

    /**
     * @ORM\ManyToMany(targetEntity="CAB\CourseBundle\Entity\ServiceTransport", inversedBy="users")
     * @ORM\JoinTable(name="cab_services_users")
     */
    private $servicesTransport;

    /**
     * @ORM\OneToMany(targetEntity="CAB\ApiBundle\Entity\TrackLogin", mappedBy="user", cascade={"remove"})
     */
    private $trackUser;


    /**
    * @var decimal $latUser
    *
    * @ORM\Column(name="lat_user", type="decimal", precision=14, scale=8, nullable=true)
    */
    private $latUser;

    /**
    * @var decimal $lngUser
    *
    * @ORM\Column(name="lng_user", type="decimal", precision=14, scale=8, nullable=true)
    */
    private $lngUser;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\VehiculeAffect", mappedBy="driver")
     */
    private $useraffects;

    /**
     * @ORM\OneToMany(targetEntity="\CAB\CourseBundle\Entity\Planing", mappedBy="driver")
     */
    private $planingDriver;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\Rating", mappedBy="driver", cascade={"remove"})
     *
     */
    private $dvratings;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\CourseHistory", mappedBy="driver")
     */
    private $courseHistory;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\CourseHistory", mappedBy="client")
     */
    private $courseHistoryClient;/**

    * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\CourseHistory", mappedBy="agent")
     */
    private $courseHistoryAgent;

    /**
     * @ORM\OneToMany(targetEntity="CAB\CourseBundle\Entity\Rating", mappedBy="client", cascade={"remove"})
     */
    private $clratings;

    /**
     * @Expose
     * @Groups({"Rating"})
     */
    private $averageDriverRating = 0;

    /**
     * @Expose
     * @var boolean
     */
    protected $enabled;

    /**
     * @var string $photoInterior
     * @ORM\Column(type="string",length=250, nullable=true)
     */
    private $nameLicence = null;

    /**
     * @Vich\UploadableField(mapping="user_licence", fileNameProperty="nameLicence")
     *
     * @var File
     *
     */
    private $fileLicence;

    /**
     * @var datetime $expireDocLicence
     *
     * @ORM\Column(type="datetime", name="expire_doc_licence", nullable=true)
     */
    private $expireDocLicence;

    /**
     * @var string $nameVisitMed
     * @ORM\Column(type="string",length=250, nullable=true)
     */
    private $nameVisitMed = null;

    /**
     * @Vich\UploadableField(mapping="user_visit_med", fileNameProperty="nameVisitMed")
     *
     * @var File
     *
     */
    private $fileVisitMed;

    /**
     * @var datetime $expireDocVisitMed
     *
     * @ORM\Column(type="datetime", name="expire_doc_visit_med", nullable=true)
     */
    private $expireDocVisitMed;

    /**
     * @var string $nameIdentityPiece
     * @ORM\Column(type="string",length=250, nullable=true)
     */
    private $nameIdentityPiece = null;

    /**
     * @Vich\UploadableField(mapping="user_identity_piece", fileNameProperty="nameIdentityPiece")
     *
     * @var File
     *
     */
    private $fileIdentityPiece;

    /**
     * @var datetime $expireDocIdentityPiece
     *
     * @ORM\Column(type="datetime", name="expire_doc_identity_piece", nullable=true)
     */
    private $expireDocIdentityPiece;

    /**
     * @var string $nameCartePro
     * @ORM\Column(type="string",length=250, nullable=true)
     */
    private $nameCartePro = null;

    /**
     * @Vich\UploadableField(mapping="user_carte_pro", fileNameProperty="nameCartePro")
     *
     * @var File
     *
     */
    private $fileCartePro;

    /**
     * @var datetime $expireDocCartePro
     *
     * @ORM\Column(type="datetime", name="expire_doc_carte_pro", nullable=true)
     */
    private $expireDocCartePro;

    /**
     * @ORM\OneToMany(targetEntity="\CAB\CallcBundle\Entity\Callc", mappedBy="agentId")
     *
     */
    private $callc;

    /**
     * @ORM\OneToOne(targetEntity="CAB\UserBundle\Entity\UserNotificationEmail", inversedBy="client" ,cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", name="notification_id", )
     */
    private $notificationEmail;

    /**
     * @ORM\OneToOne(targetEntity="CAB\UserBundle\Entity\UserNotificationSms", inversedBy="clientSms" ,cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", name="notification_sms_id", )
     */
    private $notificationSms;

    /**
     * @var string $apiToken
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apiToken;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @ORM\PostUpdate()
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Get the formatted name to display (NAME Firstname or username)
     *
     * @param $separator: the separator between name and firstname (default: ' ')
     * @return String
     * @VirtualProperty
     */
    public function getUsedName($separator = ' ')
    {
        if ($this->getLastName() != null && $this->getFirstName() != null) {
            return ucfirst(strtolower($this->getFirstName())).$separator.strtoupper($this->getLastName());
        } else {
            return $this->getUsername();
        }
    }

    /**
     * Set average driver rating in working day
     *
     * @return String
     */
    public function setAverageDriverRating($rating)
    {
        $this->averageDriverRating = $rating;

        return $this;
    }

    /**
     * Get average driver rating in working day
     *
     * @return String
     */
    public function getAverageDriverRating()
    {
        return $this->averageDriverRating;
    }

    /**
     * Method description
     *
     * @return string
     */
    public function __toString(){
        return $this->getFirstName() . ' ' . $this->getLastName();

    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile($file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets docDl.
     *
     * @param UploadedFile $file
     */
    public function setDocDl($file = null)
    {
        $this->docDl = $file;
    }

    /**
     * Get docPi.
     *
     * @return UploadedFile
     */
    public function getDocDl()
    {
        return $this->docDl;
    }

    /**
     * Sets docPi.
     *
     * @param UploadedFile $file
     */
    public function setDocPi($file = null)
    {
        $this->docPi = $file;
    }

    /**
     * Get docPi.
     *
     * @return UploadedFile
     */
    public function getDocPi()
    {
        return $this->docPi;
    }

    /**
     * Sets docMe.
     *
     * @param UploadedFile $file
     */
    public function setDocMe($file = null)
    {
        $this->docMe = $file;
    }

    /**
     * Get docPi.
     *
     * @return UploadedFile
     */
    public function getDocMe()
    {
        return $this->docMe;
    }

    /**
     * Sets docLj.
     *
     * @param UploadedFile $file
     */
    public function setDocLj($file = null)
    {
        $this->docLj = $file;
    }

    /**
     * Get docLj.
     *
     * @return UploadedFile
     */
    public function getDocLj()
    {
        return $this->docLj;
    }

    /**
     * Method description
     *
     * @param string $op
     *
     * @return string
     */
    public function getUploadRootDir($op = 'avatar')
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir($op);
    }

    /**
     * Method description
     *
     * @param string $op
     *
     * @return string
     */
    public function getUploadDir($op = 'avatar')
    {
        if ($op == 'avatar') {
            return 'uploads/avatar';
        } else {
            return 'uploads/doc_driver';
        }
    }

    /**
     * Method description
     *
     * @param string $op
     *
     * @return null|string
     */
    public function getAbsolutePath($op = 'avatar')
    {
        return null === $this->$op ? null : $this->getUploadRootDir($op).'/'.$this->$op;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->avatar = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }

        if (null !== $this->docDl) {
            $this->drivingLicense = sha1(uniqid(mt_rand(), true)).'.'.$this->docDl->guessExtension();
        }

        if (null !== $this->docLj) {
            $this->lockerJudiciare = sha1(uniqid(mt_rand(), true)).'.'.$this->docLj->guessExtension();
        }

        if (null !== $this->docPi) {
            $this->pieceIdentity = sha1(uniqid(mt_rand(), true)).'.'.$this->docPi->guessExtension();
        }

        if (null !== $this->docMe) {
            $this->medicalExamination = sha1(uniqid(mt_rand(), true)).'.'.$this->docMe->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file && null === $this->docDl && null === $this->docLj && null === $this->docPi
            && null === $this->docMe) {
            return;
        }

        if (null !== $this->file) {
            $this->file->move($this->getUploadRootDir('avatar'), $this->avatar);
            unset($this->file);
        }

        if (null !== $this->docDl) {
            $this->docDl->move($this->getUploadRootDir('drivingLicense'), $this->drivingLicense);
            unset($this->docDl);
        }

        if (null !== $this->docLj) {
            $this->docLj->move($this->getUploadRootDir('lockerJudiciare'), $this->lockerJudiciare);
            unset($this->docLj);
        }

        if (null !== $this->docPi) {
            $this->docPi->move($this->getUploadRootDir('pieceIdentity'), $this->pieceIdentity);
            unset($this->docPi);
        }

        if (null !== $this->docMe) {
            $this->docMe->move($this->getUploadRootDir('medicalExamination'), $this->medicalExamination);
            unset($this->docMe);
        }
    }

    /**
     * @ORM\PostPersist()
     */

    public function setDefaultNotificationSMS()
    {
        $smsNotification = new UserNotificationSms();
        $smsNotification->setClientSms($this);
        $this->setNotificationSms($smsNotification);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->file != "") {
            if ($file = $this->getAbsolutePath('avatar')) {
                unlink($file);
            }
        }
    }

    //Getters and setters
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postCode
     *
     * @param integer $postCode
     * @return User
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return integer
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Add contacts
     *
     * @param \CAB\CourseBundle\Entity\Company $contacts
     * @return User
     */
    public function addContact(\CAB\CourseBundle\Entity\Company $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \CAB\CourseBundle\Entity\Company $contacts
     */
    public function removeContact(\CAB\CourseBundle\Entity\Company $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add courses
     *
     * @param \CAB\CourseBundle\Entity\Course $courses
     * @return User
     */
    public function addCourse(\CAB\CourseBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \CAB\CourseBundle\Entity\Course $courses
     */
    public function removeCourse(\CAB\CourseBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set drivingLicense
     *
     * @param string $drivingLicense
     * @return User
     */
    public function setDrivingLicense($drivingLicense)
    {
        $this->drivingLicense = $drivingLicense;

        return $this;
    }

    /**
     * Get drivingLicense
     *
     * @return string
     */
    public function getDrivingLicense()
    {
        return $this->drivingLicense;
    }

    /**
     * Set medicalExamination
     *
     * @param string $medicalExamination
     * @return User
     */
    public function setMedicalExamination($medicalExamination)
    {
        $this->medicalExamination = $medicalExamination;

        return $this;
    }

    /**
     * Get medicalExamination
     *
     * @return string
     */
    public function getMedicalExamination()
    {
        return $this->medicalExamination;
    }

    /**
     * Set pieceIdentity
     *
     * @param string $pieceIdentity
     * @return User
     */
    public function setPieceIdentity($pieceIdentity)
    {
        $this->pieceIdentity = $pieceIdentity;

        return $this;
    }

    /**
     * Get pieceIdentity
     *
     * @return string
     */
    public function getPieceIdentity()
    {
        return $this->pieceIdentity;
    }

    /**
     * Set lockerJudiciare
     *
     * @param string $lockerJudiciare
     * @return User
     */
    public function setLockerJudiciare($lockerJudiciare)
    {
        $this->lockerJudiciare = $lockerJudiciare;

        return $this;
    }

    /**
     * Get lockerJudiciare
     *
     * @return string
     */
    public function getLockerJudiciare()
    {
        return $this->lockerJudiciare;
    }

    /**
     * Add zones
     *
     * @param \CAB\CourseBundle\Entity\Zone $zones
     * @return User
     */
    public function addZone(\CAB\CourseBundle\Entity\Zone $zones)
    {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones
     *
     * @param \CAB\CourseBundle\Entity\Zone $zones
     */
    public function removeZone(\CAB\CourseBundle\Entity\Zone $zones)
    {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * Add servicesTransport
     *
     * @param \CAB\CourseBundle\Entity\ServiceTransport $servicesTransport
     * @return User
     */
    public function addServicesTransport(\CAB\CourseBundle\Entity\ServiceTransport $servicesTransport)
    {
        $this->servicesTransport[] = $servicesTransport;

        return $this;
    }

    /**
     * Remove servicesTransport
     *
     * @param \CAB\CourseBundle\Entity\ServiceTransport $servicesTransport
     */
    public function removeServicesTransport(\CAB\CourseBundle\Entity\ServiceTransport $servicesTransport)
    {
        $this->servicesTransport->removeElement($servicesTransport);
    }

    /**
     * Get servicesTransport
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServicesTransport()
    {
        return $this->servicesTransport;
    }

    /**
     * Set driverWorkDay
     *
     * @param \CAB\CourseBundle\Entity\DriverWorkDays $driverWorkDay
     * @return User
     */
    public function setDriverWorkDay(\CAB\CourseBundle\Entity\DriverWorkDays $driverWorkDay = null)
    {
        $this->driverWorkDay = $driverWorkDay;

        return $this;
    }

    /**
     * Get driverWorkDay
     *
     * @return \CAB\CourseBundle\Entity\DriverWorkDays
     */
    public function getDriverWorkDay()
    {
        return $this->driverWorkDay;
    }

    /**
     * Set nightWorkingDriver
     *
     * @param boolean $nightWorkingDriver
     * @return User
     */
    public function setNightWorkingDriver($nightWorkingDriver)
    {
        $this->nightWorkingDriver = $nightWorkingDriver;

        return $this;
    }

    /**
     * Get nightWorkingDriver
     *
     * @return boolean
     */
    public function getNightWorkingDriver()
    {
        return $this->nightWorkingDriver;
    }

    /**
     * Set driverWorkNight
     *
     * @param \CAB\CourseBundle\Entity\DriverWorkNight $driverWorkNight
     * @return User
     */
    public function setDriverWorkNight(\CAB\CourseBundle\Entity\DriverWorkNight $driverWorkNight = null)
    {
        $this->driverWorkNight = $driverWorkNight;

        return $this;
    }

    /**
     * Get driverWorkNight
     *
     * @return \CAB\CourseBundle\Entity\DriverWorkNight
     */
    public function getDriverWorkNight()
    {
        return $this->driverWorkNight;
    }

    /**
     * Add driverWorkDay
     *
     * @param \CAB\CourseBundle\Entity\DriverWorkDays $driverWorkDay
     * @return User
     */
    public function addDriverWorkDay(\CAB\CourseBundle\Entity\DriverWorkDays $driverWorkDay)
    {
        $this->driverWorkDay[] = $driverWorkDay;

        return $this;
    }

    /**
     * Remove driverWorkDay
     *
     * @param \CAB\CourseBundle\Entity\DriverWorkDays $driverWorkDay
     */
    public function removeDriverWorkDay(\CAB\CourseBundle\Entity\DriverWorkDays $driverWorkDay)
    {
        $this->driverWorkDay->removeElement($driverWorkDay);
    }



    /**
     * Set driverCompany
     *
     * @param \CAB\CourseBundle\Entity\Company $driverCompany
     * @return User
     */
    public function setDriverCompany(\CAB\CourseBundle\Entity\Company $driverCompany = null)
    {
        $this->driverCompany = $driverCompany;

        return $this;
    }


    /**
     * Get driverCompany
     *
     * @return \CAB\CourseBundle\Entity\Company
     */
    public function getDriverCompany()
    {
        return $this->driverCompany;
    }

    /**
     * Add courseCreator
     *
     * @param \CAB\CourseBundle\Entity\Course $courseCreator
     * @return User
     */
    public function addCourseCreator(\CAB\CourseBundle\Entity\Course $courseCreator)
    {
        $this->courseCreator[] = $courseCreator;

        return $this;
    }

    /**
     * Remove courseCreator
     *
     * @param \CAB\CourseBundle\Entity\Course $courseCreator
     */
    public function removeCourseCreator(\CAB\CourseBundle\Entity\Course $courseCreator)
    {
        $this->courseCreator->removeElement($courseCreator);
    }

    /**
     * Get courseCreator
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseCreator()
    {
        return $this->courseCreator;
    }

    /**
     * Add courseDriver
     *
     * @param \CAB\CourseBundle\Entity\Course $courseDriver
     * @return User
     */
    public function addCourseDriver(\CAB\CourseBundle\Entity\Course $courseDriver)
    {
        $this->courseDriver[] = $courseDriver;

        return $this;
    }

    /**
     * Remove courseDriver
     *
     * @param \CAB\CourseBundle\Entity\Course $courseDriver
     */
    public function removeCourseDriver(\CAB\CourseBundle\Entity\Course $courseDriver)
    {
        $this->courseDriver->removeElement($courseDriver);
    }

    /**
     * Get courseDriver
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseDriver()
    {
        return $this->courseDriver;
    }

    /**
     * Set vehicle
     *
     * @param \CAB\CourseBundle\Entity\Vehicule $vehicle
     * @return User
     */
    public function setVehicle(\CAB\CourseBundle\Entity\Vehicule $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \CAB\CourseBundle\Entity\Vehicule
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Add trackUser
     *
     * @param \CAB\ApiBundle\Entity\TrackLogin $trackUser
     * @return User
     */
    public function addTrackUser(\CAB\ApiBundle\Entity\TrackLogin $trackUser)
    {
        $this->trackUser[] = $trackUser;

        return $this;
    }

    /**
     * Remove trackUser
     *
     * @param \CAB\ApiBundle\Entity\TrackLogin $trackUser
     */
    public function removeTrackUser(\CAB\ApiBundle\Entity\TrackLogin $trackUser)
    {
        $this->trackUser->removeElement($trackUser);
    }

    /**
     * Get trackUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTrackUser()
    {
        return $this->trackUser;
    }

    /**
     * Add geolocationDriver
     *
     * @param \CAB\CourseBundle\Entity\Geolocation $geolocationDriver
     * @return User
     */
    public function addGeolocationDriver(\CAB\CourseBundle\Entity\Geolocation $geolocationDriver)
    {
        $this->geolocationDriver[] = $geolocationDriver;

        return $this;
    }

    /**
     * Remove geolocationDriver
     *
     * @param \CAB\CourseBundle\Entity\Geolocation $geolocationDriver
     */
    public function removeGeolocationDriver(\CAB\CourseBundle\Entity\Geolocation $geolocationDriver)
    {
        $this->geolocationDriver->removeElement($geolocationDriver);
    }

    /**
     * Get geolocationDriver
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGeolocationDriver()
    {
        return $this->geolocationDriver;
    }

    /**
     * Set isCompany
     *
     * @param boolean $isCompany
     * @return User
     */
    public function setIsCompany($isCompany)
    {
        $this->isCompany = $isCompany;

        return $this;
    }

    /**
     * Get isCompany
     *
     * @return boolean
     */
    public function getIsCompany()
    {
        return $this->isCompany;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set isHandicap
     *
     * @param boolean $isHandicap
     * @return User
     */
    public function setIsHandicap($isHandicap)
    {
        $this->isHandicap = $isHandicap;

        return $this;
    }

    /**
     * Get isHandicap
     *
     * @return boolean
     */
    public function getIsHandicap()
    {
        return $this->isHandicap;
    }

    /**
     * Set privateNote
     *
     * @param string $privateNote
     * @return User
     */
    public function setPrivateNote($privateNote)
    {
        $this->privateNote = $privateNote;

        return $this;
    }

    /**
     * Get privateNote
     *
     * @return string
     */
    public function getPrivateNote()
    {
        return $this->privateNote;
    }

    /**
     * Set publicNote
     *
     * @param string $publicNote
     * @return User
     */
    public function setPublicNote($publicNote)
    {
        $this->publicNote = $publicNote;

        return $this;
    }

    /**
     * Get publicNote
     *
     * @return string
     */
    public function getPublicNote()
    {
        return $this->publicNote;
    }

    /**
     * Set addressComplement
     *
     * @param string $addressComplement
     * @return User
     */
    public function setAddressComplement($addressComplement)
    {
        $this->addressComplement = $addressComplement;

        return $this;
    }

    /**
     * Get addressComplement
     *
     * @return string
     */
    public function getAddressComplement()
    {
        return $this->addressComplement;
    }

    /**
     * Set phoneMobile
     *
     * @param string $phoneMobile
     * @return User
     */
    public function setPhoneMobile($phoneMobile)
    {
        $phoneMobile = str_replace(" ", "", $phoneMobile);
        $this->phoneMobile = $phoneMobile;

        return $this;
    }

    /**
     * Get phoneMobile
     *
     * @return string
     */
    public function getPhoneMobile()
    {
        return $this->phoneMobile;
    }

    /**
     * Set phoneHome
     *
     * @param string $phoneHome
     * @return User
     */
    public function setPhoneHome($phoneHome)
    {
        $this->phoneHome = $phoneHome;

        return $this;
    }

    /**
     * Get phoneHome
     *
     * @return string
     */
    public function getPhoneHome()
    {
        return $this->phoneHome;
    }

    /**
     * Set phoneWork
     *
     * @param string $phoneWork
     * @return User
     */
    public function setPhoneWork($phoneWork)
    {
        $this->phoneWork = $phoneWork;

        return $this;
    }

    /**
     * Get phoneWork
     *
     * @return string
     */
    public function getPhoneWork()
    {
        return $this->phoneWork;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set nameCompany
     *
     * @param string $nameCompany
     * @return User
     */
    public function setNameCompany($nameCompany)
    {
        $this->nameCompany = $nameCompany;

        return $this;
    }

    /**
     * Get nameCompany
     *
     * @return string
     */
    public function getNameCompany()
    {
        return $this->nameCompany;
    }

    /**
     * Set siren
     *
     * @param string $siren
     * @return User
     */
    public function setSiren($siren)
    {
        $this->siren = $siren;

        return $this;
    }

    /**
     * Get siren
     *
     * @return string
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * Set phoneCompany
     *
     * @param string $phoneCompany
     * @return User
     */
    public function setPhoneCompany($phoneCompany)
    {
        $this->phoneCompany = $phoneCompany;

        return $this;
    }

    /**
     * Get phoneCompany
     *
     * @return string
     */
    public function getPhoneCompany()
    {
        return $this->phoneCompany;
    }

    /**
     * Set optionsHandicap
     *
     * @param \CAB\CourseBundle\Entity\OptionsHandicap $optionsHandicap
     * @return User
     */
    public function setOptionsHandicap(\CAB\CourseBundle\Entity\OptionsHandicap $optionsHandicap = null)
    {
        $this->optionsHandicap = $optionsHandicap;

        return $this;
    }

    /**
     * Get optionsHandicap
     *
     * @return \CAB\CourseBundle\Entity\OptionsHandicap
     */
    public function getOptionsHandicap()
    {
        return $this->optionsHandicap;
    }




    /**
     * Set latUser
     *
     * @param string $latUser
     * @return User
     */
    public function setLatUser($latUser)
    {
        $this->latUser = $latUser;

        return $this;
    }

    /**
     * Get latUser
     *
     * @return string
     */
    public function getLatUser()
    {
        return $this->latUser;
    }

    /**
     * Set lngUser
     *
     * @param string $lngUser
     * @return User
     */
    public function setLngUser($lngUser)
    {
        $this->lngUser = $lngUser;

        return $this;
    }

    /**
     * Get lngUser
     *
     * @return string
     */
    public function getLngUser()
    {
        return $this->lngUser;
    }

    /**
     * Set paymentId
     *
     * @param string $paymentId
     * @return User
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * Get paymentId
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Add devices
     *
     * @param \CAB\CourseBundle\Entity\Device $devices
     * @return User
     */
    public function addDevice(\CAB\CourseBundle\Entity\Device $devices)
    {
        $this->devices[] = $devices;

        return $this;
    }

    /**
     * Remove devices
     *
     * @param \CAB\CourseBundle\Entity\Device $devices
     */
    public function removeDevice(\CAB\CourseBundle\Entity\Device $devices)
    {
        $this->devices->removeElement($devices);
    }

    /**
     * Get devices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Add paymentCards
     *
     * @param \CAB\CourseBundle\Entity\PaymentCard $paymentCards
     * @return User
     */
    public function addPaymentCard(\CAB\CourseBundle\Entity\PaymentCard $paymentCards)
    {
        $this->paymentCards[] = $paymentCards;

        return $this;
    }

    /**
     * Remove paymentCards
     *
     * @param \CAB\CourseBundle\Entity\PaymentCard $paymentCards
     */
    public function removePaymentCard(\CAB\CourseBundle\Entity\PaymentCard $paymentCards)
    {
        $this->paymentCards->removeElement($paymentCards);
    }

    /**
     * Get paymentCards
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentCards()
    {
        return $this->paymentCards;
    }

    /**
     * Add useraffects
     *
     * @param \CAB\CourseBundle\Entity\VehiculeAffect $useraffects
     * @return Vehicule
     */
    public function addUserAffect(VehiculeAffect $useraffects)
    {
        $this->useraffects[] = $useraffects;

        return $this;
    }

    /**
     * Remove useraffects
     *
     * @param \CAB\CourseBundle\Entity\VehiculeAffect $useraffects
     */
    public function removeUserAffect(VehiculeAffect $useraffects)
    {
        $this->useraffects->removeElement($useraffects);
    }

    /**
     * Get useraffects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserAffect()
    {
        return $this->useraffects;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get useraffects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUseraffects()
    {
        return $this->useraffects;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add planingDriver
     *
     * @param \CAB\CourseBundle\Entity\Planing $planingDriver
     * @return User
     */
    public function addPlaningDriver(\CAB\CourseBundle\Entity\Planing $planingDriver)
    {
        $this->planingDriver[] = $planingDriver;

        return $this;
    }

    /**
     * Remove planingDriver
     *
     * @param \CAB\CourseBundle\Entity\Planing $planingDriver
     */
    public function removePlaningDriver(\CAB\CourseBundle\Entity\Planing $planingDriver)
    {
        $this->planingDriver->removeElement($planingDriver);
    }

    /**
     * Get planingDriver
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaningDriver()
    {
        return $this->planingDriver;
    }

    /**
     * Add dvratings
     *
     * @param \CAB\CourseBundle\Entity\Rating $dvratings
     * @return User
     */
    public function addDvrating(Rating $dvratings)
    {
        $this->dvratings[] = $dvratings;

        return $this;
    }

    /**
     * Remove dvratings
     *
     * @param \CAB\CourseBundle\Entity\Rating $dvratings
     */
    public function removeDvrating(Rating $dvratings)
    {
        $this->dvratings->removeElement($dvratings);
    }

    /**
     * Get dvratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDvratings()
    {
        return $this->dvratings;
    }

    /**
     * Add clratings
     *
     * @param \CAB\CourseBundle\Entity\Rating $clratings
     * @return User
     */
    public function addClrating(Rating $clratings)
    {
        $this->clratings[] = $clratings;

        return $this;
    }

    /**
     * Remove clratings
     *
     * @param \CAB\CourseBundle\Entity\Rating $clratings
     */
    public function removeClrating(Rating $clratings)
    {
        $this->clratings->removeElement($clratings);
    }

    /**
     * Get clratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClratings()
    {
        return $this->clratings;
    }

    /**
     * Add courseHistory
     *
     * @param \CAB\CourseBundle\Entity\CourseHistory $courseHistory
     * @return User
     */
    public function addCourseHistory(\CAB\CourseBundle\Entity\CourseHistory $courseHistory)
    {
        $this->courseHistory[] = $courseHistory;

        return $this;
    }

    /**
     * Remove courseHistory
     *
     * @param \CAB\CourseBundle\Entity\CourseHistory $courseHistory
     */
    public function removeCourseHistory(\CAB\CourseBundle\Entity\CourseHistory $courseHistory)
    {
        $this->courseHistory->removeElement($courseHistory);
    }

    /**
     * Get courseHistory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseHistory()
    {
        return $this->courseHistory;
    }

    /**
     * Set agentCompany
     *
     * @param \CAB\CourseBundle\Entity\Company $agentCompany
     * @return User
     */
    public function setAgentCompany(\CAB\CourseBundle\Entity\Company $agentCompany = null)
    {
        $this->agentCompany = $agentCompany;

        return $this;
    }

    /**
     * Get agentCompany
     *
     * @return \CAB\CourseBundle\Entity\Company
     */
    public function getAgentCompany()
    {
        return $this->agentCompany;
    }

    /**
     * Set customerCompany
     *
     * @param \CAB\CourseBundle\Entity\Company $customerCompany
     * @return User
     */
    public function setCustomerCompany(\CAB\CourseBundle\Entity\Company $customerCompany = null)
    {
        $this->customerCompany = $customerCompany;

        return $this;
    }

    /**
     * Get customerCompany
     *
     * @return \CAB\CourseBundle\Entity\Company
     */
    public function getCustomerCompany()
    {
        return $this->customerCompany;
    }

    /**
     * Set businessCompany
     *
     * @param \CAB\CourseBundle\Entity\Company $businessCompany
     * @return User
     */
    public function setBusinessCompany(\CAB\CourseBundle\Entity\Company $businessCompany = null)
    {
        $this->businessCompany = $businessCompany;

        return $this;
    }

    /**
     * Get businessCompany
     *
     * @return \CAB\CourseBundle\Entity\Company
     */
    public function getBusinessCompany()
    {
        return $this->businessCompany;
    }

    /**
     * Set isCredit
     *
     * @param boolean $isCredit
     * @return User
     */
    public function setIsCredit ($isCredit)
    {
        $this->isCredit = $isCredit;

        return $this;
    }

    /**
     * Get isCredit
     *
     * @return boolean
     */
    public function getIsCredit ()
    {
        return $this->isCredit;
    }

    /**
     * Add courseDriverBack
     *
     * @param \CAB\CourseBundle\Entity\Course $courseDriverBack
     * @return User
     */
    public function addCourseDriverBack(\CAB\CourseBundle\Entity\Course $courseDriverBack)
    {
        $this->courseDriverBack[] = $courseDriverBack;

        return $this;
    }

    /**
     * Remove courseDriverBack
     *
     * @param \CAB\CourseBundle\Entity\Course $courseDriverBack
     */
    public function removeCourseDriverBack(\CAB\CourseBundle\Entity\Course $courseDriverBack)
    {
        $this->courseDriverBack->removeElement($courseDriverBack);
    }

    /**
     * Get courseDriverBack
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseDriverBack()
    {
        return $this->courseDriverBack;
    }

    /**
     * Add courseHistoryClient
     *
     * @param \CAB\CourseBundle\Entity\CourseHistory $courseHistoryClient
     * @return User
     */
    public function addCourseHistoryClient(\CAB\CourseBundle\Entity\CourseHistory $courseHistoryClient)
    {
        $this->courseHistoryClient[] = $courseHistoryClient;

        return $this;
    }

    /**
     * Remove courseHistoryClient
     *
     * @param \CAB\CourseBundle\Entity\CourseHistory $courseHistoryClient
     */
    public function removeCourseHistoryClient(\CAB\CourseBundle\Entity\CourseHistory $courseHistoryClient)
    {
        $this->courseHistoryClient->removeElement($courseHistoryClient);
    }

    /**
     * Get courseHistoryClient
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseHistoryClient()
    {
        return $this->courseHistoryClient;
    }

    /**
     * Set nameLicence
     *
     * @param string $nameLicence
     * @return User
     */
    public function setNameLicence($nameLicence)
    {
        $this->nameLicence = $nameLicence;

        return $this;
    }

    /**
     * Get nameLicence
     *
     * @return string
     */
    public function getNameLicence()
    {
        return $this->nameLicence;
    }

    /**
     * @param File $fileLicence
     */
    public function setFileLicence($fileLicence)
    {
        $this->fileLicence = $fileLicence;
        if ($this->fileLicence instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getFileLicence()
    {
        return $this->fileLicence;
    }

    /**
     * Set nameVisitMed
     *
     * @param string $nameVisitMed
     * @return User
     */
    public function setNameVisitMed($nameVisitMed)
    {
        $this->nameVisitMed = $nameVisitMed;

        return $this;
    }

    /**
     * Get nameVisitMed
     *
     * @return string
     */
    public function getNameVisitMed()
    {
        return $this->nameVisitMed;
    }


    /**
     * @param File $fileVisitMed
     */
    public function setFileVisitMed($fileVisitMed)
    {
        $this->fileVisitMed = $fileVisitMed;
        if ($this->fileVisitMed instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getFileVisitMed()
    {
        return $this->fileVisitMed;
    }

    /**
     * Set nameIdentityPiece
     *
     * @param string $nameIdentityPiece
     * @return User
     */
    public function setNameIdentityPiece($nameIdentityPiece)
    {
        $this->nameIdentityPiece = $nameIdentityPiece;

        return $this;
    }

    /**
     * Get nameIdentityPiece
     *
     * @return string
     */
    public function getNameIdentityPiece()
    {
        return $this->nameIdentityPiece;
    }


    /**
     * @param File $fileIdentityPiece
     */
    public function setFileIdentityPiece($fileIdentityPiece)
    {
        $this->fileIdentityPiece = $fileIdentityPiece;
        if ($this->fileIdentityPiece instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getFileIdentityPiece()
    {
        return $this->fileIdentityPiece;
    }

    /**
     * Set nameCartePro
     *
     * @param string $nameCartePro
     * @return User
     */
    public function setNameCartePro($nameCartePro)
    {
        $this->nameCartePro = $nameCartePro;

        return $this;
    }

    /**
     * Get nameCartePro
     *
     * @return string
     */
    public function getNameCartePro()
    {
        return $this->nameCartePro;
    }


    /**
     * @param File $fileCartePro
     */
    public function setFileCartePro($fileCartePro)
    {
        $this->fileCartePro = $fileCartePro;
        if ($this->fileCartePro instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getFileCartePro()
    {
        return $this->fileCartePro;
    }

    /**
     * Set expireDocLicence
     *
     * @param \DateTime $expireDocLicence
     * @return User
     */
    public function setExpireDocLicence($expireDocLicence)
    {
        $this->expireDocLicence = $expireDocLicence;

        return $this;
    }

    /**
     * Get expireDocLicence
     *
     * @return \DateTime
     */
    public function getExpireDocLicence()
    {
        return $this->expireDocLicence;
    }

    /**
     * Set expireDocVisitMed
     *
     * @param \DateTime $expireDocVisitMed
     * @return User
     */
    public function setExpireDocVisitMed($expireDocVisitMed)
    {
        $this->expireDocVisitMed = $expireDocVisitMed;

        return $this;
    }

    /**
     * Get expireDocVisitMed
     *
     * @return \DateTime
     */
    public function getExpireDocVisitMed()
    {
        return $this->expireDocVisitMed;
    }

    /**
     * Set expireDocIdentityPiece
     *
     * @param \DateTime $expireDocIdentityPiece
     * @return User
     */
    public function setExpireDocIdentityPiece($expireDocIdentityPiece)
    {
        $this->expireDocIdentityPiece = $expireDocIdentityPiece;

        return $this;
    }

    /**
     * Get expireDocIdentityPiece
     *
     * @return \DateTime
     */
    public function getExpireDocIdentityPiece()
    {
        return $this->expireDocIdentityPiece;
    }

    /**
     * Set expireDocCartePro
     *
     * @param \DateTime $expireDocCartePro
     * @return User
     */
    public function setExpireDocCartePro($expireDocCartePro)
    {
        $this->expireDocCartePro = $expireDocCartePro;

        return $this;
    }

    /**
     * Get expireDocCartePro
     *
     * @return \DateTime
     */
    public function getExpireDocCartePro()
    {
        return $this->expireDocCartePro;
    }

    /**
     * Add callc
     *
     * @param \CAB\CallcBundle\Entity\Callc $callc
     * @return User
     */
    public function addCallc(\CAB\CallcBundle\Entity\Callc $callc)
    {
        $this->callc[] = $callc;

        return $this;
    }

    /**
     * Remove callc
     *
     * @param \CAB\CallcBundle\Entity\Callc $callc
     */
    public function removeCallc(\CAB\CallcBundle\Entity\Callc $callc)
    {
        $this->callc->removeElement($callc);
    }

    /**
     * Get callc
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCallc()
    {
        return $this->callc;
    }

    /**
     * Set notificationEmail
     *
     * @param \CAB\UserBundle\Entity\UserNotificationEmail $notificationEmail
     * @return User
     */
    public function setNotificationEmail(\CAB\UserBundle\Entity\UserNotificationEmail $notificationEmail = null)
    {
        $this->notificationEmail = $notificationEmail;

        return $this;
    }

    /**
     * Get notificationEmail
     *
     * @return \CAB\UserBundle\Entity\UserNotificationEmail
     */
    public function getNotificationEmail()
    {
        return $this->notificationEmail;
    }

    /**
     * Set notificationSms
     *
     * @param \CAB\UserBundle\Entity\UserNotificationSms $notificationSms
     * @return User
     */
    public function setNotificationSms(\CAB\UserBundle\Entity\UserNotificationSms $notificationSms = null)
    {
        $this->notificationSms = $notificationSms;

        return $this;
    }

    /**
     * Get notificationSms
     *
     * @return \CAB\UserBundle\Entity\UserNotificationSms
     */
    public function getNotificationSms()
    {
        return $this->notificationSms;
    }


    /**
     * Set apiToken
     *
     * @param string $apiToken
     * @return User
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * Get apiToken
     *
     * @return string
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }
}
