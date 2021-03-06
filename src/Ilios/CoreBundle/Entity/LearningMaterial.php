<?php
namespace Ilios\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\Util\SecureRandom;


use Ilios\CoreBundle\Traits\DescribableEntity;
use Ilios\CoreBundle\Traits\IdentifiableEntity;
use Ilios\CoreBundle\Traits\NameableEntity;
use Ilios\CoreBundle\Traits\TitledEntity;
use Ilios\CoreBundle\Traits\TimestampableEntity;

/**
 * Class LearningMaterial
 * @package Ilios\CoreBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Ilios\CoreBundle\Entity\Repository\LearningMaterialRepository")
 * @ORM\Table(
 *  name="learning_material",
 *  uniqueConstraints={@ORM\UniqueConstraint(name="idx_learning_material_token_unique", columns={"token"})}
 * )
 *
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessType("public_method")
 */
class LearningMaterial implements LearningMaterialInterface
{
    use IdentifiableEntity;
    use TitledEntity;
    use DescribableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="learning_material_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Assert\Type(type="integer")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\SerializedName("id")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 60
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 65000
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="upload_date", type="datetime")
     *
     * @Assert\NotBlank()
     *
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\Type("DateTime<'c'>")
     * @JMS\SerializedName("uploadDate")
     */
    protected $uploadDate;

    /**
     * renamed Asset Creator
     * @var string
     *
     * @ORM\Column(name="asset_creator", type="string", length=80, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 80
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("originalAuthor")
     */
    protected $originalAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=64, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 64
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $token;

    /**
     * @var LearningMaterialUserRoleInterface
     *
     * @ORM\ManyToOne(targetEntity="LearningMaterialUserRole", inversedBy="learningMaterials")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="learning_material_user_role_id", referencedColumnName="learning_material_user_role_id")
     * })
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("userRole")
     */
    protected $userRole;

    /**
     * @var LearningMaterialStatusInterface
     *
     * @ORM\ManyToOne(targetEntity="LearningMaterialStatus", inversedBy="learningMaterials")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="learning_material_status_id", referencedColumnName="learning_material_status_id")
     * })
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $status;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="learningMaterials")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owning_user_id", referencedColumnName="user_id")
     * })
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("owningUser")
     */
    protected $owningUser;

    /**
     * @var ArrayCollection|SessionLearningMaterialInterface[]
     *
     * @ORM\OneToMany(targetEntity="SessionLearningMaterial", mappedBy="learningMaterial")
     *
     * @JMS\Expose
     * @JMS\Type("array<string>")
     * @JMS\SerializedName("sessionLearningMaterials")
     */
    protected $sessionLearningMaterials;

    /**
    * @var ArrayCollection|CourseLearningMaterialInterface[]
    *
    * @ORM\OneToMany(targetEntity="CourseLearningMaterial",mappedBy="learningMaterial")
    *
    * @JMS\Expose
    * @JMS\Type("array<string>")
    * @JMS\SerializedName("courseLearningMaterials")
    */
    protected $courseLearningMaterials;

    /**
     * renamed from citation
     * @var string
     *
     * @ORM\Column(name="citation", type="string", length=512, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 512,
     *      groups={"citation"}
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $citation;

    /**
     * @var string
     * renamed from relative_file_system_location
     *
     * @ORM\Column(name="relative_file_system_location", type="string", length=128, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 128,
     *      groups={"file"}
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("relativePath")
     */
    protected $relativePath;

    /**
     * renamed copyrightownership
     * @var boolean
     *
     * @ORM\Column(name="copyright_ownership", type="boolean", nullable=true)
     *
     * @Assert\Type(type="bool")
     *
     * @JMS\Expose
     * @JMS\Type("boolean")
     * @JMS\SerializedName("copyrightPermission")
     */
    protected $copyrightPermission;

    /**
    * @var string
    *
    * @ORM\Column(name="copyright_rationale", type="text", nullable=true)
    *
    * @Assert\Type(type="string")
    * @Assert\Length(
    *      min = 1,
    *      max = 65000
    * )
    *
    * @JMS\Expose
    * @JMS\Type("string")
    * @JMS\SerializedName("copyrightRationale")
    */
    protected $copyrightRationale;

    /**
    * @var string
    *
    * @ORM\Column(name="filename", type="string", length=255, nullable=true)
    *
    * @Assert\Type(type="string")
    * @Assert\Length(
    *      min = 1,
    *      max = 255,
     *     groups={"file"}
    * )
    *
    * @JMS\Expose
    * @JMS\Type("string")
    */
    protected $filename;

    /**
    * @var string
    *
    * @ORM\Column(name="mime_type", type="string", length=96, nullable=true)
    *
    * @Assert\Type(type="string")
    * @Assert\Length(
    *      min = 1,
    *      max = 96,
    *      groups={"file"}
    * )
    *
    * @JMS\Expose
    * @JMS\Type("string")
    */
    protected $mimetype;

    /**
    * @var string
    *
    * @ORM\Column(name="filesize", type="integer", nullable=true, options={"unsigned"=true})
    *
    * @Assert\Type(type="integer")
    *
    * @JMS\Expose
    * @JMS\Type("integer")
    */
    protected $filesize;


    /**
     * @var string
     *
     * @ORM\Column(name="web_link", type="string", length=256, nullable=true)
     *
     * @Assert\Url(groups={"link"})
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $link;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uploadDate = new \DateTime();
        $this->sessionLearningMaterials = new ArrayCollection();
        $this->courseLearningMaterials = new ArrayCollection();
        
        $this->generateToken();
    }

    /**
     * @param string $originalAuthor
     */
    public function setOriginalAuthor($originalAuthor)
    {
        $this->originalAuthor = $originalAuthor;
    }

    /**
     * @return string
     */
    public function getOriginalAuthor()
    {
        return $this->originalAuthor;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * @inheritdoc
     */
    public function generateToken()
    {
        $generator = new SecureRandom();
        $random = $generator->nextBytes(128);
        
        // prepend id to avoid a conflict
        // and current time to prevent a conflict with regeneration
        $key = $this->getId() . microtime() . $random;
        
        // hash the string to give consistent length and URL safe characters
        $this->token = hash('sha256', $key);
    }

    /**
     * @param LearningMaterialStatusInterface $status
     */
    public function setStatus(LearningMaterialStatusInterface $status)
    {
        $this->status = $status;
    }

    /**
     * @return LearningMaterialStatusInterface
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param UserInterface $user
     */
    public function setOwningUser(UserInterface $user)
    {
        $this->owningUser = $user;
    }

    /**
     * @return UserInterface
     */
    public function getOwningUser()
    {
        return $this->owningUser;
    }

    /**
     * @param LearningMaterialUserRoleInterface $userRole
     */
    public function setUserRole(LearningMaterialUserRoleInterface $userRole)
    {
        $this->userRole = $userRole;
    }

    /**
     * @return LearningMaterialUserRoleInterface
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @return \DateTime
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }


    /**
     * @param string $text
     */
    public function setCitation($citation)
    {
        $this->citation = $citation;
    }

    /**
     * @return string
     */
    public function getCitation()
    {
        return $this->citation;
    }

    /**
     * @param string $path
     */
    public function setRelativePath($path)
    {
        $this->relativePath = $path;
    }

    /**
     * @return string
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * @param bool $copyrightPermission
     */
    public function setCopyrightPermission($copyrightPermission)
    {
        $this->copyrightPermission = $copyrightPermission;
    }

    /**
     * @return bool
     */
    public function hasCopyrightPermission()
    {
        return $this->copyrightPermission;
    }

    /**
     * @param string $copyrightRationale
     */
    public function setCopyrightRationale($copyrightRationale)
    {
        $this->copyrightRationale = $copyrightRationale;
    }

    /**
     * @return string
     */
    public function getCopyrightRationale()
    {
        return $this->copyrightRationale;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filesize
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;
    }

    /**
     * @return string
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * @param string $mimetype
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
    }

    /**
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        return ($this->getResource() === null) ? null : $this->getUploadRootDir() . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return ($this->getResource() === null) ? null : $this->getUploadDir() . DIRECTORY_SEPARATOR;
    }

    /**
     * @todo: Figure out way to trigger upload through PrePersist by editing this property.
     * Perhaps a flag property managed by doctrine that we can change based on this.
     * @param UploadedFile $resource
     */
    public function setResource(UploadedFile $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return UploadedFile|\SplFileInfo
     */
    public function getResource()
    {
        if ($this->resource === null && $this->path !== null) {
            return new \SplFileInfo($this->getAbsolutePath());
        }
        return $this->resource;
    }

    /**
     * @return void
     */
    public function upload()
    {
        if ($this->getResource() === null) {
            return;
        }

        $this->getResource()->move(
            $this->getUploadRootDir(),
            $this->getResource()->getClientOriginalName()
        );

        $this->path = $this->getResource()->getClientOriginalName();

        $this->resource = null;
    }

    /**
     * @return string
     */
    private function getUploadRootDir()
    {
        return __DIR__ . "/../../../../web" . $this->getUploadDir();
    }

    /**
     * @todo: Create magic file bucket sauce.
     * @return string
     */
    private function getUploadDir()
    {
        $uploadDir = 'uploads';
        return $uploadDir;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @param string $webLink
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param Collection $courseLearningMaterials
     */
    public function setCourseLearningMaterials(Collection $courseLearningMaterials = null)
    {
        $this->courseLearningMaterials = new ArrayCollection();
        if (is_null($courseLearningMaterials)) {
            return;
        }

        foreach ($courseLearningMaterials as $courseLearningMaterial) {
            $this->addCourseLearningMaterial($courseLearningMaterial);
        }
    }

    /**
     * @param CourseLearningMaterialInterface $courseLearningMaterial
     */
    public function addCourseLearningMaterial(CourseLearningMaterialInterface $courseLearningMaterial)
    {
        $this->courseLearningMaterials->add($courseLearningMaterial);
    }

    /**
     * @return ArrayCollection|CourseLearningMaterialInterface[]
     */
    public function getCourseLearningMaterials()
    {
        return $this->courseLearningMaterials;
    }

    /**
     * @param Collection $sessionLearningMaterials
     */
    public function setSessionLearningMaterials(Collection $sessionLearningMaterials = null)
    {
        $this->sessionLearningMaterials = new ArrayCollection();
        if (is_null($sessionLearningMaterials)) {
            return;
        }

        foreach ($sessionLearningMaterials as $sessionLearningMaterial) {
            $this->addSessionLearningMaterial($sessionLearningMaterial);
        }
    }

    /**
     * @param SessionLearningMaterialInterface $sessionLearningMaterial
     */
    public function addSessionLearningMaterial(SessionLearningMaterialInterface $sessionLearningMaterial)
    {
        $this->sessionLearningMaterials->add($sessionLearningMaterial);
    }

    /**
     * @return ArrayCollection|SessionLearningMaterialInterface[]
     */
    public function getSessionLearningMaterials()
    {
        return $this->sessionLearningMaterials;
    }
}
