# Copyright 2018 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

"""This script is used to synthesize generated parts of this library."""

import synthtool as s
import synthtool.gcp as gcp
import logging

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICGenerator()

for version in ['V2', 'V2beta2', 'V2beta3']:
    lower_version = version.lower()
    library = gapic.php_library(
        service='tasks',
        version=lower_version,
        config_path=f'artman_cloudtasks_{lower_version}.yaml',
        artman_output_name=f'google-cloud-tasks-{lower_version}')

    # copy all src including partial veneer classes
    s.move(library / 'src')

    # copy proto files to src also
    s.move(library / f'proto/src/Google/Cloud/Tasks', f'src/')
    s.move(library / f'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / f'proto/src/GPBMetadata/Google/Cloud/Tasks', f'metadata/')

# fix year
s.replace(
    'src/V2beta*/**/*.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'tests/*/V2beta*/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'src/V2/**/*.php',
    r'Copyright \d{4}',
    r'Copyright 2019')
s.replace(
    'tests/*/V2/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2019')

# Use new namespace in the doc sample. See
# https://github.com/googleapis/gapic-generator/issues/2141
s.replace(
    'src/*/Gapic/CloudTasksGapicClient.php',
    r'Task_View',
    r'Task\\View')

# Change the wording for the deprecation warning.
s.replace(
    'src/*/*_*.php',
    r'will be removed in the next major release',
    'will be removed in a future release')

# Comment out initialization of \GPBMetadata\Google\Api\Resource until GA
# common protos are available in google-cloud-php.
# https://github.com/googleapis/google-cloud-php/pull/1732
s.replace(
    'metadata/V2/*.php',
    r'\\GPBMetadata\\Google\\Api\\Resource',
    r'//\\GPBMetadata\\Google\\Api\\Resource')
