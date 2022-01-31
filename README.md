[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)

<p align="center"><a href="https://www.sorutahtasi.com" target="_blank"><img src="https://user-images.githubusercontent.com/34205493/151849821-f45b56bb-9b54-478b-ac32-278d148e7013.png" height="50"></a></p>

# Soru Tahtası

Soru Tahtası, Google Oyun ve Uygulama Akademisi canlı yayınlarında yayıncıya soru iletilmesi, bu soruların ve etkinliklerin yönetiminin kolaylaştırılması için geliştirilmiştir.

# Nasıl Kullanılır?
<ol>
  <li>
      <a href="https://www.sorutahtasi.com/register">Kayıt ol</a> sayfasında E-Mail, ad soyad ve şifre bilgilerini girmenizin ardından "kayıt ol" butonuna tıklatın
  </li>
  
  <li>
      <a href="https://sorutahtasi.com/user/profile">Kullanıcı profili</a> sayfası üzerinden profil bilgilerinizi, şifrenizi değiştirebilirsiniz. İki faktörlü          kimlik doğrulamasını etkinleştirebilir, mevcut oturumlarınızı görüntüleyebilir / diğer oturumlardan çıkış yapabilir ve hesabınızı silebilirsiniz. 
  </li>

  <li>
      <a href="https://sorutahtasi.com/events">Etkinlikler</a> sayfasında oluşturulmuş etkinlikleri görüntüleyebilirsiniz.
  </li>
    
  <li>
      <a href="https://sorutahtasi.com/event/1">Etkinlik</a> sayfasında etkinliğe gönderilmiş soruları görebilir, etkinliği oluşturan sizseniz soruları cevaplandı olarak işaretleyebilir ya da silebilirsiniz. Soruyu soran kişi olarak giriş yaptıysanız ise sorunuzu silebilir veya düzenleyebilirsiniz.
  </li>
    
  <li>
      <a href="https://sorutahtasi.com/dashboard">Panel</a> sayfası üzerinden oluşturduğunuz tüm etkinlikleri görebilir ve silebilirsiniz.
  </li>
</ol>

# Nasıl Kurulur?
<ol>
    <li><a href="https://github.com/berkaycatak/question-board">Proje anasayfasında</a> "Code" butonuna tıklatıp "Download ZIP"e tıklatıp projeyi bilgisayarınıza indirin.</li>
      <img alt="download zip" src="https://user-images.githubusercontent.com/34205493/151851687-3e72a952-ac66-41ab-b3c7-0addabfc004e.png">
    <li>Terminal üzerinden proje dizinine girin.</li>
    <li>"composer update" komutunu çalıştırın.</li>
    <li>.env dosyasını açıp veritabanı kullanıcı adınızı ve şifrenizi girin.</li>
    <li>Terminal üzerinden "php artisan migrate" komutunu çalıştırın.</li>   
    <li>Projeyi ayağa kaldırmak için yine terminal üzerinden "php artisan serve" komutunu çalıştırın.</li>
</ol>

# Ekran Görüntüleri
    
### Etkinlikler sayfası
<img alt="events-page" src="https://user-images.githubusercontent.com/34205493/151851031-560a052d-7aca-415a-a084-05d8cd86631f.png">
    
### Etkinlik sayfası
<img alt="event-single-page" src="https://user-images.githubusercontent.com/34205493/151851038-cc80659e-0507-4e79-a785-682143d6671d.png">

### Giriş sayfası
<img alt="login-page" src="https://user-images.githubusercontent.com/34205493/151851051-79594e49-5c8c-4dfe-a933-c11adf5d51bf.png">

### Profil sayfası
<img alt="profile-page" src="https://user-images.githubusercontent.com/34205493/151851054-cee4adf8-2b80-419d-b565-c789bf556842.png">


# License

> Copyright 2021 Berkay Çatak.
>
> Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
>
> http://www.apache.org/licenses/LICENSE-2.0
>
> Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
>
